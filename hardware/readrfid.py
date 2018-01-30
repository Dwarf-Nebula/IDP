import RPi.GPIO as GPIO
import MFRC522
import signal

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

def readCard(continues=True):
    # Set reading True so the reader will read
    reading = True
    
    # This loop keeps checking for chips. If one is near it will get the UID and authenticate
    while reading:

        # Scan for cards    
        (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)

        # Get the UID of the card
        (status,uid) = MIFAREReader.MFRC522_Anticoll()
        
        # If we have the UID, continue
        if status == MIFAREReader.MI_OK:
            # This is the default key for authentication
            key = [0xFF,0xFF,0xFF,0xFF,0xFF,0xFF]

            # Select the scanned tag
            MIFAREReader.MFRC522_SelectTag(uid)

            # Authenticate
            status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)

            # Check if authenticated
            if (status == MIFAREReader.MI_OK):
                MIFAREReader.MFRC522_Read(8)
                MIFAREReader.MFRC522_StopCrypto1()
                reading = False
            else:
                reading = False
        if continues == False:
            status = ""
            break
    if (status == MIFAREReader.MI_OK):
        return("{}{}{}{}".format(uid[0], uid[1], uid[2], uid[3]))
    else:
        return