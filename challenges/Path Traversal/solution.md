## Level 5
Goal: RCE được server

### Giới thiệu

#### Chức năng của chương trình
- Level 5 là game Flappy Bird phiên bản CyberJutsu.  
![image](https://user-images.githubusercontent.com/42104948/201710639-bc070986-e99f-44b1-beaf-e864abc55c78.png)
- Game 2 thì đang phát triển nên chưa chơi được.  
![image](https://user-images.githubusercontent.com/42104948/201710743-c5e335aa-f60b-4b2f-aedf-d5cb66d6709f.png)

#### Mã nguồn chương trình
- Có 2 folder lớn là configs và src, configs chứa các file cấu hình server và src chứa mã nguồn của chương trình  
![image](https://user-images.githubusercontent.com/42104948/201713457-720377f6-23c8-4e56-be60-b0c9f2b0afc4.png)
- Bên trong src gồm có:
    - Folder static: chứa các file ảnh và âm thanh
    - Folder views: chứa các file html dùng để hiển thị giao diện cho người dùng
    - File index.php: là file xử lý chính của ứng dụng
- Phân tích source code trong file index.php ta thấy
    - Dòng 3 có sự xuất hiện của untrusted data là biến `$_GET['game']`
    - Mặc định khi truy cập, trang web sẽ hiển thị view từ file `fatty-bird-1.html`
    - Nếu gói GET gửi lên có kèm theo giá trị của tham số `game`, thì giá trị này sẽ được gán vào biến `$game`
    - Dòng 21 cho thấy biến `$game` sau đó được cộng chuỗi với một đường dẫn và đi vào hàm `include`  
![image](https://user-images.githubusercontent.com/42104948/201713942-ed57e393-eb41-412d-996d-b4ca97f36079.png)
    - PHP `include` là một hàm cho phép copy hết tất cả nội dung của file khác vào file hiện tại, rồi thực thi  
![image](https://user-images.githubusercontent.com/42104948/201713154-47b12f6c-ecb0-462a-907b-b34a4e4da49a.png)
- Tóm lại, file index.php làm nhiệm vụ chính là hiển thị giao diện dựa vào giá trị của tham số GET `game`

### Thử khai thác vào `include`
- Ta có thể tác động vào `$_GET['game']` vì đây là dữ liệu được gửi từ client
- Thử thay đổi giá trị của game thành một file khác cũng trong thư mục views.  
![image](https://user-images.githubusercontent.com/42104948/201712372-0d565b70-13c6-473f-8c70-ec93bf73a15f.png)
- Ta thấy trang web render đúng nội dung của từng file mình vừa include
- Vậy còn những file khác trên server thì sao? Liệu truyền bất kì đường dẫn file nào vào `include` cũng đọc được?
- Nhưng `$game` đã bị prefix bởi `./views/`, ta có thể include một file khác không nằm trong thư mục `views` được không? Liệu có thể sử dụng `../` để thoát ra khỏi thư mục này?
- Thử với file `convit.png` trong folder `img` đi. Truyền vào tham số `?game=../static/img/convit.png`  
![image](https://user-images.githubusercontent.com/42104948/201712415-f8d8c161-a290-4ed8-912d-149ab86033eb.png)
- Chương trình báo lỗi. Nhưng đây là lỗi **Parse error** chứ không phải lỗi không có quyền đọc. Nghĩa là `include` vẫn có thể đọc được nhưng không parse được file ảnh như thế này
- Đồng thời ta cũng xác nhận được ở `?game` bị Path Traversal
- Vậy thử với file text `/etc/passwd` thì sao?  
![image](https://user-images.githubusercontent.com/42104948/201712434-4be0c74d-80e0-4ad2-b8aa-b6ad2a84f57f.png)
- Ta đã tấn công Path Traversal và đọc được file bất kỳ trên hệ thống

### Tìm cách thực thi lệnh
- Như đã nói ở trên, `include` sau khi copy nội dung file, nó sẽ thực thi luôn nếu có code trong đó.
- Ta có thể nghĩ đến việc upload một file PHP và include file này
- Tuy nhiên ứng dụng không cho phép upload gì lên server
- Vậy có cách nào không cần upload file nhưng vẫn đẩy được code PHP của mình vào một file nào đó trên server, sau đó chỉ cần include file này?
- Để làm được như vậy, ta có thể nghĩ đến cách thay đổi nội dung của một file có sẵn trên server
- Có một file trên server cho phép ghi user input vào nội dung file, đó là access.log của apache
- Thông thường khi cài đặt apache người ta sẽ cấu hình 2 file là access log và error log để theo dõi các request gửi lên web server và điều tra khi có sự cố trong lúc xử lý request
- Để xem cấu hình này, ta vào file `000-default.conf`.  
![image](https://user-images.githubusercontent.com/42104948/201710953-45f8bbee-4edf-44b1-b65b-87a45136669b.png)  
  Đây là cấu hình mặc định của apache. Và giá trị mặc định của `${APACHE_LOG_DIR}` là `/var/log/apache2/`
- Thử truy cập đến `access.log` ta thấy ở đây chứa các HTTP request gửi lên server  
![image](https://user-images.githubusercontent.com/42104948/201712499-0605541f-21aa-4762-8dae-439a39f3e365.png)
- Cú pháp của từng dòng log là:  
![image](https://user-images.githubusercontent.com/42104948/201712533-4ae845fa-a3fe-4ea1-be21-7daca0d14e79.png)
- Như vậy, một số trường ta có thể thay đổi trong gói GET là: Request String (cụ thể là giá trị của `?game`), Referer, và User-Agent
- Nếu gửi lên server một cú request có chứa code PHP ở một trong 3 vị trí trên, sau đó include file access.log này thì sao?
- Thử gửi một cú GET request có User-Agent là `<? phpinfo() ?>`
- Sau đó include access.log, ta thấy trang web đã thực thi được PHP  
![image](https://user-images.githubusercontent.com/42104948/201714721-8b919912-9205-4468-8d8e-8633c1fe6562.png)
- Để RCE, ta chỉ cần thay `phpinfo()` thành `system($_GET['cmd'])` và truyền câu lệnh muốn thực thi vào tham số `cmd`  
![image](https://user-images.githubusercontent.com/42104948/201714911-8ce06a22-d749-46e0-b3cd-0ddb7ee046ce.png)
- Kiểu tấn công đưa malicious code vào log được gọi là Log Poisoning, và chỉ có tác dụng khi kết hợp với lỗi Local File Inclusion (LFI)


## Level 6
Goal: RCE được server

### Giới thiệu

#### Chức năng của chương trình
- Level 6 là một ứng dụng cho phép người dùng lưu trữ hình ảnh bằng cách upload ảnh lên server, và sau đó có thể Download về nếu muốn
- Ngoài chức năng upload file ảnh thông thường, ứng dụng còn cho phép upload lên một gói zip, sau đó sẽ giúp chúng ta giải nén thành nhiều file ảnh  
![image](https://user-images.githubusercontent.com/42104948/202154342-e6b98fdf-13c1-46c7-8378-a48583232a52.png)

#### Mã nguồn chương trình
- Tương tự level 5, có 2 folder lớn là configs và src, configs chứa các file cấu hình server và src chứa mã nguồn của chương trình  
![image](https://user-images.githubusercontent.com/42104948/202168137-26df68af-5815-4b55-8366-68b340e99677.png)
- Bên trong src gồm có:
    - Folder css: chứa các file định nghĩa bố cục và giao diện cho trang web
    - Folder images: chứa các file html dùng để hiển thị giao diện cho người dùng
    - File index.php: là file xử lý chính của ứng dụng
- Phân tích source code trong file index.php ta thấy
    - Có sự xuất hiện của 2 untrusted data là `$_SESSION['dir']` (dòng 7) và `$_FILES["file"]` (dòng 14)
        - `$_SESSION['dir']`: đường dẫn thư mục trên server để user upload file, mỗi thư mục được tạo tương ứng với từng session truy cập trang web
        - `$_FILES["file"]`: mảng chứa các thông tin về file mà user upload lên
    - Đoạn code xử lý chính của chương trình là từ 17-26  
![image](https://user-images.githubusercontent.com/42104948/202157083-cfd5ac8a-cc8f-4113-8917-0c1905baa93d.png)  
    Chương trình sẽ xử lý khác nhau với 2 loại file:
        - File `.zip`: đưa vào hàm `_unzip_file_ziparchive` để tiếp tục xử lý
        - File khác: upload lên folder của user (đã được tạo ở dòng 7)
    - Hàm `_unzip_file_ziparchive` nhận vào 2 đối số là `$file` và `$to`. Nó sẽ thực hiện giải nén các file trong `$file` vào đường dẫn `$to`
        - Ở bước giải nén có một vòng lặp để lấy ra tên và nội dung của từng file
        - Thông tin tên và nội dung này được copy sang một file mới để tái tạo lại file như ban đầu trước khi nén  
![image](https://user-images.githubusercontent.com/42104948/202154769-0a2de3fa-6708-425d-8f1d-2f7385856f5f.png)
- Tóm lại, file index.php làm nhiệm vụ chính là tạo folder để user upload ảnh lên và xử lý file nén dạng `.zip` khi user có nhu cầu upload nhiều ảnh cùng lúc

### Vấn đề trong việc thiếu kiểm soát untrusted data
- `$_SESSION['dir']`
    - Ví dụ bằng một cách nào đó ta có được cookie `PHPSESSID` của user khác (tấn công Session Hijacking chẳng hạn), ta có thể sử dụng cookie này để xem tất cả ảnh cũng như có thể upload bất kì thứ gì vào folder của user đó
    - Tuy nhiên vì tất cả user sử dụng ứng dụng này có quyền ngang nhau, và goal của thử thách này là RCE nên việc kiểm soát được biến này không mang nhiều ý nghĩa lắm
- `$_FILES["file"]`
    - Đoạn code chỉ phân loại file có đuôi `.zip` khỏi các file còn lại để đưa vào hàm xử lý riêng dành cho file nén. Cuối cùng tất cả các file này đều được upload lên server
    - Vậy chuyện gì sẽ xảy ra nếu ta upload một file PHP?
    - Mình tạo một file info.php với nội dung là `<? phpinfo() ?>` rồi upload lên server  
    - Và thử truy cập đến file xem liệu code PHP của mình có được chạy
    - Kết quả là KHÔNG. Mình đoán là server đã có cấu hình gì đặc biệt để không chạy file PHP do user upload lên  
![image](https://user-images.githubusercontent.com/42104948/202155281-e7a5a524-9d14-4109-baaf-f16b0235ecf4.png)
![image](https://user-images.githubusercontent.com/42104948/202159485-97cf794f-08c0-48e2-8189-2fb74eaad91a.png) 
    - Xem qua các file cấu hình của level 6, ta thấy trong file apache2.conf có đoạn config sau  
![image](https://user-images.githubusercontent.com/42104948/202157380-40236c2d-df53-4c82-8dd3-dfe59662d91e.png)  
    Anh lập trình viên cũng comment rằng đoạn config này có chức năng ngăn chặn việc thực thi code PHP trong folder upload
    - Hmm... "trong folder upload" ??? Vậy nếu là ngoài folder upload thì sao nhỉ? Chuyện gì sẽ xảy ra nếu mình có thể upload một file ra ngoài folder `/var/www/html/upload/`?
    - Dòng 24 đang cấu thành một đường dẫn file để lưu file vừa upload lên vào folder của user đã được tạo trước đó
    - Ví dụ lúc nãy mình upload file tên `info.php` lên thì giá trị của `$newFile=/var/www/html/upload/19371e671442ac2e210e3c13145e0606/info.php`
    - Vậy nếu ta có thể upload một file có tên là `../../info.php` thì có phải `$newFile=/var/www/html/upload/19371e671442ac2e210e3c13145e0606/../../info.php`  
    Và file info.php lúc này sẽ nằm ở `/var/www/html/info.php`?
    - Thử đổi tên file `info.php` thành `../../info.php` rồi upload lại bằng Burp Repeater
    - Và thử truy cập đến file xem liệu code PHP của mình có được chạy  
![image](https://user-images.githubusercontent.com/42104948/202158319-2de24e91-5333-4a81-a3b9-fe6253a12a7a.png)
    - File của mình được báo đã upload thành công nhưng khi truy cập đến lại không tìm thấy???
    - Để tìm hiểu chuyện gì đã xảy ra hãy debug một chút. Mình đặt các hàm `var_dump()` để xem flow của untrusted data đi vào chương trình như thế nào
![image](https://user-images.githubusercontent.com/42104948/202164735-c5d0bcad-c572-4c23-9c42-045e630028ca.png)
    - Hóa ra biến `$_FILES["file"]["name"]` của PHP đã xử lý gì đó khi nhận giá trị của tham số `filename` từ browser. Cuối cùng các ký tự đặc biệt phía trước bị loại bỏ hết chỉ còn tên và đuôi file  
![image](https://user-images.githubusercontent.com/42104948/202165340-23f7c8d0-f6be-4a44-8e69-2de11ce64d4a.png)
    - Do đó giả thuyết upload file có tên `../../info.php` để Path Traversal ra ngoài thư mục upload phá sản
- Đừng vội bỏ cuộc, tiếp tục đọc source code của hàm `_unzip_file_ziparchive` trong file index.php ta lại thấy thêm sự xuất hiện của 2 untrusted data đáng chú ý là `$info['name']` (dòng 44) và `$contents` (dòng 47)
- Cả 2 unstrusted data này đều không hề qua lớp kiểm tra bảo mật nào
- Vậy chuyện gì sẽ xảy ra nếu ta upload một file nén có chứa file PHP bên trong lên server?
- File info.php lúc nãy mình sẽ nén thành file `nenphp.zip`  
    Và upload lên server  
![image](https://user-images.githubusercontent.com/42104948/202159368-90ea4611-144e-40df-9540-7a73fd68fe85.png)  
  Vẫn như hành vi lúc nãy, file PHP của chúng ta không được thực thi  
![image](https://user-images.githubusercontent.com/42104948/202155281-e7a5a524-9d14-4109-baaf-f16b0235ecf4.png)  
- Dòng 52 cho thấy file info.php vẫn được giải nén vào thư mục upload  
![image](https://user-images.githubusercontent.com/42104948/202158878-503244a9-ca10-476e-8881-99e0c7886496.png)
- Ở đây ta thấy `$info['name']` nằm ở vị trí tương tự như `$file_name` ở dòng 24 nhưng có sự khác biệt:
    - `$file_name` lấy giá trị từ `$_FILES["file"]["name"]`,
    - còn `$info['name']` lấy giá trị từ object `ZipArchive()`
- Lúc nãy ý tưởng của ta bị fail do `$_FILES["file"]["name"]` đã xử lý loại bỏ phần `../../` để Path Traversal, vậy liệu `ZipArchive()` cũng hành xử như thế?
- Để kiểm chứng, mình cũng sẽ `var_dump($info['name'])`  
![image](https://user-images.githubusercontent.com/42104948/202170819-5d9ef213-9fcb-4398-a3a8-1040b5a7d52f.png)  
  Đối với file info.php trong nenphp.zip, mình thử đổi tên thành `../../info.php` một lần nữa.
- Tuy nhiên việc đổi tên cũng khó khăn hơn vì file đã được nén lại rồi. Cú pháp của gói zip có nhiều byte đặc biệt, mà chỉ cần thay đổi sai chút xíu là sẽ khiến cho `ZipArchive::CHECKCONS` trả về lỗi và ta sẽ không vượt qua được đoạn check  
![image](https://user-images.githubusercontent.com/42104948/202159024-d43413bd-82c5-43ce-9cbb-300e6979e369.png)
- Lúc này ta cần tìm cách đổi tên file bên trong một gói zip
- Để hiểu rõ hơn về cấu trúc file nén các bạn nên xem qua video [12.7% WEBSITE TRÊN THẾ GIỚI ĐÃ BỊ LỖI NÀY!](https://youtu.be/hB7BzU0iTnY) của CyberJutsu
- Cũng trong video có nhắc đến một trường hợp Path Traversal liên quan đến việc thay đổi tên file bên trong file nén, đó chính là lỗi Zip Slip
- Để exploit lỗi Zip Slip này, người ta thường dùng công cụ cho phép thay đổi tên file sao cho có chứa `../`. Một trong các công cụ nổi tiếng là [evilarc](https://github.com/ptoomey3/evilarc/blob/master/evilarc.py)
- Sau khi download file `evilarc.py` ta thực hiện lệnh
```
python3 evilarc.py -d 2 -o unix info.php
```
- Trong đó:  
    - `-d`: độ sâu, nôm na là số lượng `../` ta muốn thêm vào tên file
    - `-o`: tạo file theo tiêu chuẩn của hệ điều hành nào
- File nén được tạo ra có tên là evil.zip
- Ta sẽ thử upload gói zip này lên server, và theo lý thuyết file info.php của chúng ta sẽ được giải nén ra ở `/var/www/html/info.php`  
![image](https://user-images.githubusercontent.com/42104948/202172449-427cdf85-96d1-4483-9437-eebd2c942049.png)
- Như vậy nếu ta truy cập vào `/info.php` trên server được nghĩa là ta đã thành công  
![image](https://user-images.githubusercontent.com/42104948/202166684-9ed142c9-598a-4075-b191-7a9773fe4413.png)
- Cuối cùng, chỉ cần thay đổi nội dung của file info.php thành `<? system($_GET['cmd']); ?>` là ta đã upload được shell lên server và có thể chạy bất kỳ lệnh nào  
![image](https://user-images.githubusercontent.com/42104948/202167191-366b8ccb-dab5-43d8-9c67-f11f6443ea75.png)
