YK EGGS PROFIT CALCULATOR - VERSION 1

REQUIREMENTS
- XAMPP for Windows
- Apache
- MySQL

INSTALLATION
1. Install XAMPP.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Copy the "yk-eggs" folder into:
   C:\xampp\htdocs\
4. Open phpMyAdmin:
   http://localhost/phpmyadmin
5. Import database.sql OR open the SQL tab and paste its contents.
6. Visit:
   http://localhost/yk-eggs/

DEFAULT MYSQL SETTINGS
Host: 127.0.0.1
Database: yk_eggs
Username: root
Password: (blank)

HOW PROFIT IS CALCULATED
Purchase Cost = Trays Purchased x Buying Price
Broken Trays = Trays Purchased x Breakage %
Sellable Trays = Trays Purchased - Broken Trays
Total Sales = Sellable Trays x Selling Price
Total Cost = Purchase Cost + Transport + Loading + Other Expenses
Net Profit = Total Sales - Total Cost
Break-even Price = Total Cost / Sellable Trays
Profit Margin = Net Profit / Total Sales x 100

NOTE
This Version 1 stores calculation history but does not yet include customer accounts,
inventory management, actual sales records, user login, or supplier management.
