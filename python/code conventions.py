def faculteit(n):
    if n == 0 or n == 1:
        return 1
    else:
        return n * faculteit(n - 1)

print(faculteit(5))  # Output: 120

def hooftletter(text):
    return text.upper()

print(hooftletter("hello world"))  # Output: HELLO WORLD