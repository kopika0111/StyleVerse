from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector
from transformers import pipeline

app = Flask(__name__)
CORS(app)  # Enable CORS for cross-origin requests

# Load AI Model
chatbot = pipeline("text-generation", model="facebook/blenderbot-400M-distill")

# MySQL Database Connection
db = mysql.connector.connect(
    host="localhost",
    user="root",  # Change if needed
    password="",  # Your MySQL password
    database="styleverse"
)

# Fetch Product Details Function
def get_product_info(product_name):
    cursor = db.cursor(dictionary=True)
    query = "SELECT name, price, description FROM products WHERE name LIKE %s LIMIT 1"
    cursor.execute(query, ("%" + product_name + "%",))
    product = cursor.fetchone()
    cursor.close()
    return product

# Chatbot API Route
@app.route("/chat", methods=["POST"])
def chat():
    data = request.get_json()
    user_message = data.get("message", "")

    # Check if user is asking about a product
    product_info = get_product_info(user_message)
    if product_info:
        response = f"Product: {product_info['name']}\nPrice: {product_info['price']}\nDescription: {product_info['description']}"
    else:
        response = chatbot(user_message, max_length=100)[0]["generated_text"]

    return jsonify({"reply": response})

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)
