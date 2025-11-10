Step-by-step (simple version)
1️⃣ Open the site

Go to
👉 http://localhost/ubat/login.php

You’ll see the home page with buttons to Sign Up or Login.

2️⃣ Sign Up

Go to signup.php

Fill in name, email, password

Click Sign Up

✅ Your account is saved in users.json

You are automatically logged in and sent to the Dashboard

3️⃣ Login

If you already have an account → go to login.php

Enter email + password

✅ On success, you go to dashboard.php

4️⃣ Dashboard

Here you can:

Convert money using the Frankfurter API

See:

The latest conversion (amount, rate, date)

The total conversions

The total users

When you convert:

It calls https://api.frankfurter.app/latest?amount=1&from=USD&to=EUR

The result is saved in your session

Total conversions count in stats.json increases

5️⃣ Logout

Click Logout

It clears your session and returns to index.php

📁 Files involved
File	What it does
index.php	Home page
signup.php	Sign-up form
login.php	Login form
dashboard.php	Converter + stats
logout.php	Logs out and redirects
users.json	Saves user info
stats.json	Saves total conversions
includes/config.php	Functions (login, save, API call, etc.)
