"""
StyleVerse Recommender System with Recommendation Reasons
"""

import pandas as pd
import numpy as np
import mysql.connector
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from datetime import datetime

# DB connection
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="styleverse"
)

# Load data
products = pd.read_sql("SELECT product_id, name, category_id, subcategory_id, tags FROM products", conn)
ratings = pd.read_sql("SELECT user_id, product_id, rating FROM ratings", conn)
behaviors = pd.read_sql("SELECT user_id, product_id, action_type, timestamp FROM user_behavior", conn)
search_history = pd.read_sql("SELECT user_id, keyword FROM search_history WHERE searched_at > NOW() - INTERVAL 90 DAY", conn)

# TF-IDF for content-based
products['combined'] = products['tags'].fillna('') + ' cat' + products['category_id'].astype(str) + ' sub' + products['subcategory_id'].astype(str)
tfidf = TfidfVectorizer()
tfidf_matrix = tfidf.fit_transform(products['combined'])
cos_sim = cosine_similarity(tfidf_matrix)

# Collaborative filtering with KNN-like user similarity
user_matrix = pd.crosstab(ratings['user_id'], ratings['product_id'])
user_sim = cosine_similarity(user_matrix.fillna(0))
user_sim_df = pd.DataFrame(user_sim, index=user_matrix.index, columns=user_matrix.index)

# Trending products
behaviors['timestamp'] = pd.to_datetime(behaviors['timestamp'])
recent = behaviors[behaviors['timestamp'] > pd.Timestamp.now() - pd.Timedelta(days=30)]
trending = recent[recent['action_type'] == 'view'].groupby('product_id').size().reset_index(name='views')
trending_ids = trending.sort_values('views', ascending=False)['product_id'].tolist()

# Seasonal (current month views)
current_month = datetime.now().month
seasonal = behaviors[behaviors['timestamp'].dt.month == current_month]
seasonal_ids = seasonal['product_id'].value_counts().head(10).index.tolist()

# Helper functions
def get_knn_recs(user_id, top_n=5):
    if user_id not in user_sim_df:
        return []
    sims = user_sim_df[user_id].sort_values(ascending=False)[1:top_n+1].index
    seen = ratings[ratings['user_id'] == user_id]['product_id']
    recs = ratings[ratings['user_id'].isin(sims) & ~ratings['product_id'].isin(seen)]
    return recs['product_id'].value_counts().head(top_n).index.tolist()

def get_search_matches(user_id):
    user_keywords = search_history[search_history['user_id'] == user_id]['keyword'].str.lower().tolist()
    if not user_keywords:
        return []
    keyword_pattern = '|'.join([k.replace(' ', '|') for k in user_keywords])
    matched = products[products['name'].str.contains(keyword_pattern, case=False, na=False) |
                       products['tags'].str.contains(keyword_pattern, case=False, na=False)]
    return matched['product_id'].tolist()

def get_related_products(product_id):
    row = products[products['product_id'] == product_id]
    if row.empty:
        return []
    cat = row['category_id'].values[0]
    sub = row['subcategory_id'].values[0]
    rel = products[(products['category_id'] == cat) & (products['subcategory_id'] == sub)]
    return rel['product_id'].tolist()

# Generate recommendations with reason
user_ids = ratings['user_id'].unique()
now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
recs = []

for user_id in user_ids:
    seen = ratings[ratings['user_id'] == user_id]['product_id'].tolist()
    candidates = products[~products['product_id'].isin(seen)]

    search_set = set(get_search_matches(user_id))
    knn_set = set(get_knn_recs(user_id))

    for pid in candidates['product_id']:
        idx = products[products['product_id'] == pid].index[0]
        reasons = []

        content_score = np.mean([cos_sim[idx][products[products['product_id'] == s].index[0]] for s in seen]) if seen else 0
        if content_score > 0.2: reasons.append("Content-Based")

        knn_score = 1.0 if pid in knn_set else 0
        if knn_score > 0: reasons.append("Similar Users")

        search_score = 1.0 if pid in search_set else 0
        if search_score > 0: reasons.append("Search Match")

        related_score = 1.0 if any(rid in seen for rid in get_related_products(pid)) else 0
        if related_score > 0: reasons.append("Same Category")

        seasonal_score = 1.0 if pid in seasonal_ids else 0
        if seasonal_score > 0: reasons.append("Seasonal")

        trending_score = 1.0 if pid in trending_ids else 0
        if trending_score > 0: reasons.append("Trending")

        final_score = round((0.25 * content_score) + (0.2 * knn_score) + (0.2 * search_score) +
                            (0.15 * related_score) + (0.1 * seasonal_score) + (0.1 * trending_score), 4)

        if final_score > 0:
            recs.append({
                'user_id': user_id,
                'product_id': pid,
                'score': final_score,
                'reason': ", ".join(reasons),
                'created_at': now
            })

# Save to CSV
rec_df = pd.DataFrame(recs)
rec_df.to_csv("datasets/recommendations.csv", index=False)

# Save to MariaDB (add reason column to table first)
cursor = conn.cursor()
cursor.execute("DELETE FROM recommendations")
insert_sql = "INSERT INTO recommendations (user_id, product_id, score, reason, created_at) VALUES (%s, %s, %s, %s, %s)"
for _, row in rec_df.iterrows():
    cursor.execute(insert_sql, (int(row['user_id']), int(row['product_id']), float(row['score']), row['reason'], row['created_at']))
conn.commit()
cursor.close()
conn.close()

print("✅ Full hybrid recommendations with reasons saved to CSV and DB.")
