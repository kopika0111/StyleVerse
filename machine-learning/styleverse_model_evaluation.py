"""
Full Evaluation Script for StyleVerse Recommender System
Includes:
- RMSE (ratings)
- Precision@K, Recall@K, Hit Rate@K (implicit behavior)
- Match % for search keywords
- Recommendation Reason Breakdown
"""

import pandas as pd
import numpy as np
import mysql.connector
from sklearn.metrics import mean_squared_error
from math import sqrt
from collections import defaultdict

# DB Connection
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="styleverse"
)

# Parameters
K = 5

# Load data
ratings = pd.read_sql("SELECT user_id, product_id, rating FROM ratings", conn)
recommendations = pd.read_sql("SELECT user_id, product_id, score, reason FROM recommendations", conn)
behaviors = pd.read_sql("SELECT user_id, product_id, action_type, timestamp FROM user_behavior", conn)
search_history = pd.read_sql("SELECT user_id, keyword FROM search_history", conn)

# ===============================
# 1. RMSE (Ratings vs Score)
# ===============================
merged_ratings = ratings.merge(recommendations, on=["user_id", "product_id"])
rmse = sqrt(mean_squared_error(merged_ratings['rating'], merged_ratings['score'])) if not merged_ratings.empty else None

# ===============================
# 2. Precision, Recall, HitRate based on user_behavior (implicit)
# ===============================
behaviors['timestamp'] = pd.to_datetime(behaviors['timestamp'])
behaviors = behaviors.sort_values("timestamp")
test_set = defaultdict(set)
train_set = defaultdict(set)

for user_id, group in behaviors.groupby("user_id"):
    actions = group
    split = int(len(actions) * 0.8)
    train_actions = actions.iloc[:split]
    test_actions = actions.iloc[split:]
    train_set[user_id] = set(train_actions['product_id'])
    test_set[user_id] = set(test_actions['product_id'])

recommendation_lookup = defaultdict(list)
for _, row in recommendations.iterrows():
    recommendation_lookup[row['user_id']].append(row['product_id'])

hit_rates, precisions, recalls = [], [], []

for user, test_items in test_set.items():
    recs = recommendation_lookup.get(user, [])[:K]
    if not test_items or not recs:
        continue
    hits = len(set(recs) & test_items)
    hit_rates.append(1.0 if hits > 0 else 0)
    precisions.append(hits / K)
    recalls.append(hits / len(test_items))

avg_hit_rate = round(np.mean(hit_rates), 4)
avg_precision = round(np.mean(precisions), 4)
avg_recall = round(np.mean(recalls), 4)

# ===============================
# 3. Search Match Score
# ===============================
search_match_count = 0
total_users_with_search = 0

search_group = search_history.groupby('user_id')['keyword'].apply(lambda x: ' '.join(x)).reset_index()

for _, row in search_group.iterrows():
    user_id = row['user_id']
    keywords = row['keyword'].lower().split()
    recs = [str(pid) for pid in recommendation_lookup.get(user_id, [])]
    if not recs:
        continue
    total_users_with_search += 1
    if any(kw in ' '.join(recs).lower() for kw in keywords):
        search_match_count += 1

search_match_rate = round(search_match_count / total_users_with_search, 4) if total_users_with_search > 0 else 0.0

# ===============================
# 4. Breakdown by Reason Column
# ===============================
reason_counts = recommendations['reason'].str.split(', ').explode().value_counts()

# ===============================
# Final Output
# ===============================
print("📊 FULL MODEL EVALUATION RESULTS")
print(f"RMSE (Ratings):            {round(rmse, 4) if rmse else 'N/A'}")
print(f"Precision@{K} (Behavior):   {avg_precision}")
print(f"Recall@{K} (Behavior):      {avg_recall}")
print(f"Hit Rate@{K} (Behavior):    {avg_hit_rate}")
print(f"Search Match %:            {search_match_rate}")

print("\n🔍 Breakdown of Recommendation Reasons:")
for reason, count in reason_counts.items():
    print(f"- {reason}: {count}")
