# 💡 Smart Feedback Collection and Analysis System

A modern web-based platform for collecting, managing, and analyzing user feedback intelligently.  
Built using **PHP**, **MySQL**, and **Bootstrap**, this system integrates basic **AI-powered sentiment analysis** to classify feedback as *Positive*, *Negative*, or *Neutral* and provides insightful visualizations for administrators.

---

## 🚀 Key Features

- 🔐 **Secure Authentication**
  - Login & signup for users and admin roles  
  - OTP verification during registration  

- 🗣️ **Feedback Management**
  - Users can submit categorized feedback with ratings and comments  
  - Guests can submit feedback anonymously  

- 🧠 **Sentiment Analysis**
  - Keyword-based sentiment detection (positive, negative, neutral)  

- 📊 **Admin Dashboard**
  - Interactive analytics using **Chart.js**
  - Filter feedbacks by category or sentiment
  - Export feedbacks to CSV
  - Manage and delete feedbacks  

- 🏢 **Company/Organization Integration**
  - Optional company role support (can be extended for multiple organizations)  

---

## 🧱 Tech Stack

| Layer | Technologies Used |
|-------|--------------------|
| **Frontend** | HTML5, CSS3, Bootstrap 4, JavaScript |
| **Backend** | PHP (Core) |
| **Database** | MySQL |
| **Visualization** | Chart.js |
| **Execution** | Built-in PHP Server (`php -S localhost:8000`) |

---

## ⚙️ Installation & Setup (Without XAMPP)

1. **Ensure you have PHP & MySQL installed**
   - Check versions using:  
     ```bash
     php -v
     mysql --version
     ```

2. **Clone or Download the Project**
   ```bash
   git clone https://github.com/yourusername/smart-feedback.git
   cd smart-feedback
