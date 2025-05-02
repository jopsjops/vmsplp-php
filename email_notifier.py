import smtplib
import mysql.connector
from email.message import EmailMessage
from dotenv import load_dotenv
import os
from urllib.parse import parse_qs
import cgi

# Load environment variables
load_dotenv()

sender_email = os.getenv("SENDER_EMAIL")
sender_password = os.getenv("SENDER_PASSWORD")

# Handle web request input (GET/POST via CGI)
form = cgi.FieldStorage()
student_id = form.getvalue('student_id')

print("Content-Type: text/plain\n")  # Needed for CGI response

if not student_id:
    print("❌ No Student ID provided.")
    exit()

# Connect to DB
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="violationdb"
)
cursor = db.cursor()

# Query student info
cursor.execute("""
    SELECT Student_Name, Email, Violation
    FROM student_info
    WHERE Student_ID = %s AND Email_Status = 'Pending'
""", (student_id,))
student = cursor.fetchone()

if not student:
    print(f"❌ No pending email for Student ID {student_id}")
    cursor.close()
    db.close()
    exit()

Student_Name, receiver_email, Violation = student

# Email setup
msg = EmailMessage()
msg['Subject'] = "Pamantasan ng Lungsod ng Pasig Violation Alert"
msg['From'] = sender_email
msg['To'] = receiver_email

html_content = f"""
<html>
    <body>
        <p>Dear <strong>{Student_Name}</strong>,</p>
        <p>You have been recorded for the following violation:</p>
        <p><strong>{Violation}</strong></p>
        <p>Please report to the student success office to resolve this.</p>
        <p>- PLP Violation Monitoring System</p>
    </body>
</html>
"""
msg.add_alternative(html_content, subtype='html')

# Send the email
try:
    with smtplib.SMTP("smtp.gmail.com", 587) as smtp:
        smtp.starttls()
        smtp.login(sender_email, sender_password)
        smtp.send_message(msg)

    # Mark email status as 'Sent'
    cursor.execute("UPDATE student_info SET Email_Status='Sent' WHERE Student_ID=%s", (student_id,))
    db.commit()
    print("✅ Email sent successfully.")

except Exception as e:
    print(f"❌ Error sending email: {str(e)}")

cursor.close()
db.close()
