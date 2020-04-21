from PIL import Image
from pytesseract import *

filename = "/Users/HOME/Desktop/test.jpg"
image=Image.open(filename)
text=image_to_string(image, lang="kor")

with open("sample.txt","w") as f:
    f.write(text)
