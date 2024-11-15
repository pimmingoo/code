import datetime as time

# Leest hoeveel woorden er in het bestand staan
def count_words_in_file(file_path): 
    try:
        with open(file_path, 'r') as file:
            content = file.read()
            words = content.split()
            return len(words)
    except FileNotFoundError:
        return "Bestand niet gevonden. Controleer de bestandsnaam en het pad."

# Het vertellen van de woorden die in het bestand staan
def count_words():
    file_path = "text.txt"  
    aantal_woorden = count_words_in_file(file_path)
    print(f"Het aantal woorden in het bestand is: {aantal_woorden}")

def datum_bijhouden():
    date_time = time.datetime.now()
    print(f"Het moment is: {date_time}")
    with open("datum.txt", 'a') as file:
        file.write(f"{date_time}\n")
        print("Datum is opgeslagen.")

def text_omkeren():
    with open("text.txt", 'r') as file:
        content = file.read()

    omgekeert_content = content[::-1]
    
    with open("omgekeert_text.txt", 'w') as r_file:
        r_file.write(omgekeert_content)

text_omkeren()