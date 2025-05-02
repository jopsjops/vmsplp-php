import smtplib
import mysql.connector
from email.message import EmailMessage
from dotenv import load_dotenv
import os

# Load environment variables from .env file
load_dotenv()

# Get email and password from environment variables
sender_email = os.getenv("SENDER_EMAIL")
sender_password = os.getenv("SENDER_PASSWORD")

# Connect to your MySQL database (violationdb)
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",  # Adjust password if needed
    database="violationdb"
)

cursor = db.cursor()

# Fetch student data from the student_info table
cursor.execute("""
    SELECT Violation, Student_ID, Student_Name, Email
    FROM student_info
""")
students = cursor.fetchall()

if not students:
    print("No students found in the database.")
else:
    for student in students:
        Violation, Student_Id, Student_Name, receiver_email = student

        # Fetch the actual violation for the student from the violations table
        cursor.execute("""
            SELECT Violation
            FROM student_info
            WHERE Student_ID = %s AND Email_Status = 'Pending'
        """, (Student_Id,))
        
        violation_data = cursor.fetchone()  # Fetch the violation for this student
        
        if violation_data:
            Violation = violation_data[0]  # The actual violation for the student
        else:
            Violation = Violation  # Default message if no violation is found

        # Prepare the email content
        msg = EmailMessage()
        msg['Subject'] = "Pamantasan ng Lungsod ng Pasig Violation Alert"
        msg['From'] = sender_email
        msg['To'] = receiver_email

        # HTML email content
        html_content = f"""
        <html>
            <body>
                <p>Dear <strong>{Student_Name}</strong>,</p>
                <p>We hope this message finds you well. This is to formally inform you that you have been recorded for the following violation:</p>
                <p><strong>{Violation}.</strong></p>
                <p>Kindly report to the student success office at your earliest convenience to address this matter accordingly.</p>
                <p>Thank you for your attention.</p>
                <br> 
                <p>Sincerely,<br>PLP Violation Monitoring System</p>
            </body>
        </html>
        """
        msg.add_alternative(html_content, subtype='html')

        # Send the email
        try:
            with smtplib.SMTP("smtp.gmail.com", 587) as smtp:
                smtp.starttls()  # Secure the connection
                smtp.login(sender_email, sender_password)
                smtp.send_message(msg)
            print(f"Email successfully sent to: {receiver_email}")

            # Optionally, you could update the email status in student_info or another related table if needed
            # Example:
            # cursor.execute("UPDATE student_info SET email_status = 'Sent' WHERE Student_ID = %s", (Student_Id,))

        except Exception as e:
            print(f"Failed to send email to: {receiver_email}. Error: {e}")
            # Optionally, log failed status
            # cursor.execute("UPDATE student_info SET email_status = 'Failed' WHERE Student_ID = %s", (Student_Id,))

# Commit changes and close the connection
db.commit()
cursor.close()
db.close()
print("✅ Email processing complete.")
