# weak-login
example of a LAMP style secure login

Create a user, and attempt to login. Passwords are hashed iteratively with a randomly generated salt, all stored in the DB.

Iterative hashing prevents brute-force attacks by forcing each guess to take about one second.
