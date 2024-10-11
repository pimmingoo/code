import time

leeftijd = int(input("Wat is je leeftijd? :"))

if leeftijd < 18:
    print("je bent minderjarig")
    time.sleep(3)

elif leeftijd >= 18 and leeftijd < 64: 
    print("je bent volwassen")
    time.sleep(3)

else:
    print("je bent senior")
    time.sleep(3)