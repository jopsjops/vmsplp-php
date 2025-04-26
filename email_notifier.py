import smtplib
import mysql.connector
from email.message import EmailMessage
from dotenv import load_dotenv
import os

# Load variables from .env
load_dotenv()

# Get email and password from env
sender_email = os.getenv("SENDER_EMAIL")
sender_password = os.getenv("SENDER_PASSWORD")

# Connect to your database
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # No password
    database="violationdb"
)

cursor = db.cursor()

# Fetch violations that haven't been emailed
cursor.execute("SELECT id, email, student_id, violation FROM violations WHERE email_status = 'Pending'")
violations = cursor.fetchall()

if not violations:
    print("No pending emails to send.")
else:
    for v in violations:
        id, receiver_email, name, violation = v

        msg = EmailMessage()
        msg['Subject'] = "Pamantasan ng Lungsod ng Pasig Violation Alert"
        msg['From'] = sender_email
        msg['To'] = receiver_email

        # HTML email content
        html_content = f"""
        <html>
            <body>
                <p>Dear {name},</p>
                <p>We hope this message finds you well. This is to formally inform you that you have been recorded for the following violation:</p>
                <p><strong>{violation}</strong></p>
                <p>Kindly report to the student success office at your earliest convenience to address this matter accordingly.</p>
                <p>Thank you for your attention.</p>
                <br> 
                <p>Sincerely,<br>PLP Violation Monitoring System</p>
            </body>
        </html>
        """

        msg.add_alternative(html_content, subtype='html')

        try:
            with smtplib.SMTP("smtp.gmail.com", 587) as smtp:
                smtp.starttls()
                smtp.login(sender_email, sender_password)
                smtp.send_message(msg)
            print(f" Email successfully sent to: {receiver_email}")
            cursor.execute("UPDATE violations SET email_status = 'Sent' WHERE id = %s", (id,))
        except Exception as e:
            print(f" Failed to send email to: {receiver_email}. Error: {e}")
            cursor.execute("UPDATE violations SET email_status = 'Failed' WHERE id = %s", (id,))

# Commit changes and close connection
db.commit()
cursor.close()
db.close()
print("✅ Email processing complete.")
