import random

def min_operations_to_make_beautiful(s):
    operations = 0
    for i in range(1, len(s)):
        if s[i] == s[i - 1] or abs(ord(s[i]) - ord(s[i - 1])) == 1:
            operations += 1
            arr = [ord(s[i]), ord(s[i-1]), ord(s[i+1]), ord(s[i-1])-1, ord(s[i-1])-2, ord(s[i+1])-1, ord(s[i+1])+1]
            s[i] = chr(random123(arr))
        print(s[i])
    return operations

def random123(arr):
    start_range = 97
    end_range = 123
    excluded_numbers = arr

    while True:
        random_number = random.randint(start_range, end_range)
        if random_number not in excluded_numbers:
            return random_number


s = "aBbac"
result = min_operations_to_make_beautiful(list(s))
print(result)
