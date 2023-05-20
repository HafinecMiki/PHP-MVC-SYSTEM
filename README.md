# PHP-MVC-SYSTEM
PHP Simple routing and MVC system

Please download and install Xampp:

https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.4/xampp-windows-x64-8.2.4-0-VS16-installer.exe/download

After installation, please move project to C:\xampp\htdocs folder and run Apache and MySQL server in Xampp Controll Panel Apache. Open phpmyadmin page and put sql commands.

Database: `mvc`

```CREATE Database mvc;```

Click the database and put sql command:

```
--
-- Table structure for table `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `msg` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_birth_date` date,
  `user_website` varchar(250),
  `user_token` varchar(250),
  `user_created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
  
  ```
After creating database, open command line in project folder and run:

```composer install```

```php server/server.php```

Open in browser:

```localhost/PHP-MVC-SYSTEM```
