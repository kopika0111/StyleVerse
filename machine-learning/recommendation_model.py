import pandas as pd
import numpy as np
from sklearn.neighbors import NearestNeighbors
from sklearn.metrics.pairwise import cosine_similarity
import mysql.connector
import json

# Function to connect to the database
def connect_to_db():
    connection = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='styleverse'
    )
    return connection

# 1. Collaborative Filtering (User-Item Based)
def collaborative_filtering():
    # Fetch user behavior data from MySQL database
    conn = connect_to_db()
    query = "SELECT user_id, product_id, action_type FROM user_behavior"
    df = pd.read_sql(query, conn)

    # Pivot data to create a user-item matrix
    pivot_data = df.pivot(index='user_id', columns='product_id', values='action_type').fillna(0)
    pivot_data = pivot_data.applymap(lambda x: 1 if x != 0 else 0)  # Convert actions to binary (0 or 1)

    # Collaborative Filtering using KNN
    knn = NearestNeighbors(metric='cosine', algorithm='brute', n_neighbors=5)
    knn.fit(pivot_data)

    user_id = 1  # Example user ID for whom to generate recommendations
    user_vector = pivot_data.loc[user_id].values.reshape(1, -1)

    distances, indices = knn.kneighbors(user_vector, n_neighbors=5)

    recommended_products = pivot_data.columns[indices[0]].tolist()
    return recommended_products

# 2. Content-Based Filtering (Item-Item Based)
def content_based_filtering():
    # Example product features (e.g., category, price, etc.)
    product_features = pd.read_csv("product_features.csv")  # Assuming columns: product_id, feature_1, feature_2, ...

    # Content-based Filtering using KNN
    knn = NearestNeighbors(n_neighbors=5, metric='cosine')
    knn.fit(product_features.iloc[:, 1:])  # Use all features except product_id

    product_id = 101  # Example product ID for which to generate recommendations
    product_vector = product_features.loc[product_features['product_id'] == product_id].iloc[:, 1:].values

    distances, indices = knn.kneighbors(product_vector, n_neighbors=5)

    recommended_products = product_features.iloc[indices[0]]['product_id'].tolist()
    return recommended_products

# 3. Hybrid Recommendation (Combining Collaborative + Content-Based)
def hybrid_recommendation():
    collaborative_recs = collaborative_filtering()
    content_based_recs = content_based_filtering()

    # Combine both recommendations (simple union of two lists)
    all_recommendations = list(set(collaborative_recs + content_based_recs))
    return all_recommendations

# 4. Store Recommendations in the Database
def store_recommendations(user_id, recommended_products):
    conn = connect_to_db()
    cursor = conn.cursor()

    for product_id in recommended_products:
        # Example score (you could calculate this based on distance or similarity)
        score = np.random.uniform(0, 1)

        insert_query = "INSERT INTO recommendations (user_id, product_id, score) VALUES (%s, %s, %s)"
        cursor.execute(insert_query, (user_id, product_id, score))

    conn.commit()
    cursor.close()
    conn.close()
    print(f"Recommendations for user {user_id} have been stored.")

# 5. Load User Behavior and Process it
def log_user_behavior(user_id, product_id, action_type):
    conn = connect_to_db()
    cursor = conn.cursor()

    # Insert user behavior data into the database
    query = "INSERT INTO user_behavior (user_id, product_id, action_type) VALUES (%s, %s, %s)"
    cursor.execute(query, (user_id, product_id, action_type))

    conn.commit()
    cursor.close()
    conn.close()
    print(f"User behavior for User ID {user_id} logged: {action_type} on Product ID {product_id}")

# Main Function
def main():
    user_id = 1
    product_id = 101
    action_type = 'click'

    # Log user behavior (click, view, etc.)
    log_user_behavior(user_id, product_id, action_type)

    # Generate recommendations
    recommendations = hybrid_recommendation()
    print(f"Recommended products for User {user_id}: {recommendations}")

    # Store recommendations in the database
    store_recommendations(user_id, recommendations)

if __name__ == "__main__":
    main()
