# Tổng quát ứng dụng Preview service

## Phân tích ứng dụng
![image](https://user-images.githubusercontent.com/42104948/205811962-a0a24dc3-5ece-43b9-a283-f8cd9b2439db.png)

Ứng dụng Preview service có 3 tab chính: Feature, Shutdown, và Admin

- Tab Feature: nhập vào một URL ảnh, ứng dụng sẽ truy cập đến URL đó và lấy ảnh về hiển thị lên cho người dùng
- Tab Shutdown: có khả năng sẽ làm gì đó ảnh hưởng đến ứng dụng / server, cho sụp nguồn chẳng hạn, vì vậy mới giới hạn chỉ cho truy cập từ local (127.0.0.1)
- Tab Admin: tương tự cũng chỉ cho truy cập từ local

## Đọc code
- Trước tiên ta sẽ tiến hành đọc code của 3 file liên quan đến 3 tab vừa rồi
	- `feature.php`:
	
	- ![image](https://user-images.githubusercontent.com/42104948/205856506-4c52d6d2-f817-4008-a2ce-3c6174a693ee.png)  

		- Untrusted data `$_GET['url']` xuất hiện ở dòng thứ 5, tiếp đó đi qua hàm check cú pháp URL có hợp lệ hay không
		- Sau khi vượt qua bước kiểm tra, hàm `file_get_contents` sẽ đi đến URL user truyền vào, lấy data về base64 encode, và lưu vào biến `$content`
		- Cuối cùng đoạn code 36-39 sẽ trả giá trị biến `$content` ra giao diện cho người dùng
		
		![image](https://user-images.githubusercontent.com/42104948/205856457-07a6097b-6151-4538-968b-0c509a7f569d.png)

	- `shutdown.php` và `admin.php`:
		- 2 file này có điểm chung là đoạn check: nếu biến `$_SERVER['REMOTE_ADDR']` là `127.0.0.1` thì sẽ được truy cập vào endpoint này:
			- `shutdown.php` sẽ thực hiện shutdown server để bảo trì
			- `admin.php` sẽ show các thông tin về server
		- Còn ngược lại sẽ thông báo rằng user không có quyền
		- Về `$_SERVER['REMOTE_ADDR']` theo document của PHP
		
		![image](https://user-images.githubusercontent.com/42104948/205812289-5281ebbe-a974-4af4-97f8-224e88b5e9fd.png)
		
		nói nôm na là lấy IP của user đang truy cập đến
		- Để xem cụ thể giá trị `$_SERVER['REMOTE_ADDR']` là gì, hãy đặt một hàm `var_dump()` trong `shutdown.php`
		
		![image](https://user-images.githubusercontent.com/42104948/205815293-64883607-689f-4de7-b923-6856853866ea.png)
		
		![image](https://user-images.githubusercontent.com/42104948/205820245-d534f566-8f75-4571-a90d-b4bac4d0a1bd.png)
		
		- Ta biết được user hiện tại đang truy cập đến `admin.php` đang ở IP `172.29.0.1`
- Có thể hiểu cơ chế kiểm tra truy cập này của anh developer như sau: nếu có người truy cập endpoint đặc biệt từ local (`127.0.0.1`) thì người đó chính là admin và có quyền truy cập
- Từ đó ta thấy các lỗ hổng là:
	- Đoạn code không hề xác thực user admin mà chỉ cần người nào đó ở `127.0.0.1` truy cập đến các tính năng đặc biệt đều được
	- Ứng dụng Preview service, hay cụ thể là `file_get_contents` sẽ truy cập đến URL bất kì được truyền vào từ untrusted data `$_GET['url']`

# Flag 1: Đọc bí mật trong trang dashboard của admin tại admin.php

## Vậy liệu có cách nào để ta chạm đến endpoint đặc biệt từ local (mà không cần phải thực sự có mặt ở đó)?
- Ta đã biết `$_SERVER['REMOTE_ADDR']` sẽ lấy IP của user đang truy cập đến endpoint
- Nếu "user đó" chính là ứng dụng Preview service luôn, thì có phải IP lúc này sẽ là `127.0.0.1` không?
- Để kiểm chứng, ta sẽ cho Preview service tự truy cập đến `shutdown.php`, bằng cách gửi cho nó URL: `http://127.0.0.1/shutdown.php`  
  Dữ liệu được trả về dạng base64, xem kết quả decode trong panel Inspector

![image](https://user-images.githubusercontent.com/42104948/206137650-61c83e04-4799-4f11-b7d5-9ca98bda5ece.png)


- Nhờ `var_dump` ta đã thấy được giá trị của `$_SERVER['REMOTE_ADDR']` lúc này chính là `127.0.0.1`
- Theo lý thuyết, lúc này server đã sập rồi. Thử truy cập lại ứng dụng

![image](https://user-images.githubusercontent.com/42104948/205820023-f0c46819-8514-42d6-a6e9-88ee0e2a4a04.png)

- Vậy ta đã thành công "nhờ" Preview service truy cập đến tab Shutdown. Lúc này để start lại server, ta cần nhấn vào đường link dẫn đến file `up.php`
- Tiếp theo, thử với tab Admin

![image](https://user-images.githubusercontent.com/42104948/205816392-14fb58f3-2fa9-4688-b747-b3c97046702c.png)

- Tuy nhiên lúc này panel Inspector lại quá nhỏ nên khó xem kết quả decode đối với dữ liệu gồm nhiều dòng. Ta có thể:
	- Cách 1: Bôi đen dữ liệu bị encode và nhấn `Ctrl + Shift + B`
	
	![image](https://user-images.githubusercontent.com/42104948/205820758-01298d04-de18-49a7-a544-ea55cfef057e.png)
	
	- Cách 2: Nhờ browser render. Đem hết nội dung bên trong attribute `src` của tag `<img>` lên thanh URL của browser, thay chuỗi `image/png` thành `text/html`, và `Ctrl + U` để view source
	
	![image](https://user-images.githubusercontent.com/42104948/205827119-b48f17e0-eabd-4926-b676-03153fb708b3.png)
	
- Đọc được thông tin của server và tìm được flag đầu tiên
- Vậy với vị trí là một người dùng bất kỳ ngoài Internet, ta đã thành công truy cập được các tính năng mà chỉ cho phép người dùng nội bộ truy cập

# Flag 2: Tìm được một service đang chạy ở port khác trên server

## Nếu ứng dụng có thể truy cập đến các endpoint đặc biệt của chính nó, vậy ngoài chính nó thì sao? Liệu trên server này còn host các ứng dụng / trang web nào khác nữa không?
- Để kiểm chứng ta sẽ dùng tính năng Burp Intruder để gửi gói tin HTTP đến hàng loạt nhiều port khác nhau và check xem liệu có service nào đang chạy ở port đó không
- Gửi gói tin GET có tham số `url` qua tab Intruder, thêm dấu `:` và mark nơi để truyền payload

![image](https://user-images.githubusercontent.com/42104948/205835716-b0fdd64d-79d6-4da8-b082-a614f2fb1644.png)

- Vào sub tab Payloads, cấu hình Payload type dạng Numbers, range 1-65535. Với
	- 1: số port thấp nhất hợp lệ. Do port 0 là một port đặc biệt, không dùng để host service
	- 65535: số port cao nhất hợp lệ
- Bấm Start attack và chờ đợi Burp gửi đi các request

![image](https://user-images.githubusercontent.com/42104948/205835948-95888e9c-adc0-4e33-8bf2-2b53ef27cd4e.png)

- Sau khi Start attack, ta có thể theo dõi sự khác biệt trong nội dung của gói response bằng cách bấm vào cột (Response) Length

![image](https://user-images.githubusercontent.com/42104948/205837463-75bebc4e-d923-4d9d-a557-1d91f1995e1e.png)

- Xem kết quả của Intruder attack, ta thấy:
	- Port 80: chính là nơi đang host Preview service, vì nội dung trả về chính là nội dung của file source `index.php`
	- Port 8888: oh ta đã tìm được một service khác trên cùng server này và lấy được flag thứ hai
	
	![image](https://user-images.githubusercontent.com/42104948/205837260-14872a8c-be35-458a-8755-45ac3ba8cd09.png)

- Vậy ta đã thành công truy tìm được một service khác cùng nằm trên server.

# Flag 3: Tìm lỗi & Khai thác service nội bộ vừa tìm được

## Phân tích service
- Decode base64 nội dung của trang web này thấy đó là file source `index.php` trong thư mục `web-internal`
- Service này liệt kê một danh sách gồm 3 chủ đề, mỗi chủ đề được gắn một hyperlink, đều truy cập đến endpoint `post.php` và truyền vào `id` một con số

![image](https://user-images.githubusercontent.com/42104948/205838902-d1f8182e-dfe9-49bf-ad33-085f974ef512.png)

- Đọc source của file `post.php`, ta phát hiện untrusted data là `$_GET['id']`

![image](https://user-images.githubusercontent.com/42104948/205839110-0b587974-62ae-4530-b795-c7a6bc273768.png)

- Untrusted data này không được kiểm tra kỹ càng mà đã đưa vào câu query ở dòng 7 bằng cách nối chuỗi   
-> Chỗ này đã bị lỗi SQL Injection

## SQL Injection trong service nội bộ
- Nhưng để chắc chắn có thể khai thác được, hãy kiểm chứng trên ứng dụng
- Từ Preview service, gửi URL có dạng: `http://127.0.0.1:8888/post.php?id='`
- Vì trong `post.php` anh developer có để đoạn code thông báo khi có lỗi xảy ra cho việc debug, nên khá dễ dàng để ta nhìn thấy dòng lỗi quen thuộc

![image](https://user-images.githubusercontent.com/42104948/205839425-57d563d4-c717-46c8-bc41-ebbca87181e6.png)

-> Có thể khai thác SQL Injection
- Thử với một payload SQL Injection đơn giản để tìm số cột trong bảng. Từ source code post.php ta biết chắc chắn table `Posts` có ít nhất 3 cột

![image](https://user-images.githubusercontent.com/42104948/205839836-dd43d17b-f2b2-43b8-8153-01d1d7904e90.png)

`1 UNION SELECT 1,2,3`
- Lưu ý: payload này sẽ được xử lý 2 lần, 1 lần ở param `url` và 1 lần ở param `id`, do đó ta phải encode 2 lần trước khi ghép payload vào gói tin

![image](https://user-images.githubusercontent.com/42104948/205841162-7cc971a4-ef2c-49ca-86b5-2dfb81b6589c.png)

- Trang web trả về lỗi. Tăng lên 4 thì có kết quả trả về  
-> Table `Posts` có 4 cột

![image](https://user-images.githubusercontent.com/42104948/205841429-f263b1e3-e5d3-488f-b640-be26634990fc.png)

- Đây là code html nên ta sẽ copy đoạn data này lên browser để render

![image](https://user-images.githubusercontent.com/42104948/205841729-45f5449d-0090-495f-bfee-a5f5fec4afe2.png)

- Dựa vào kết quả thấy được các cột 2, 3, 4 là những cột được in ra màn hình. Chúng ta sẽ dựa vào các cột này để leak data ra
	- Lấy tên các bảng khác trong database  
	`1 UNION SELECT NULL,NULL,NULL,table_name FROM information_schema.tables`
	- Phát hiện ra một bảng tên `Flag` nè
	
	![image](https://user-images.githubusercontent.com/42104948/205841981-3c99f1f3-ef6f-4b30-b2a2-f82caea701b4.png)

	- Tiếp tục tìm tên các cột trong bảng `Flag` này  
	`1 UNION SELECT NULL,NULL,table_name,column_name FROM information_schema.columns WHERE table_name = 'Flag'`
	  
	![image](https://user-images.githubusercontent.com/42104948/205842109-06b3396f-dd71-478d-9ab4-d45c7af0ae3d.png)

	- Vậy table `Flag` có một column tên `secret`. Dump secret này ra là chúng ta sẽ có flag thứ ba  
	`1 UNION SELECT NULL,NULL,NULL,secret FROM Flag`
	  
	![image](https://user-images.githubusercontent.com/42104948/205842231-2a45f909-340c-4a09-ab97-1bae6733a511.png)
	
- Vậy kết hợp SSRF và SQL Injection, ta đã thành công khai thác service ẩn này và lấy được dữ liệu quan trọng trong Database

# Flag 4: Có một server FTP nội bộ, tìm đọc nội dung file `/flag.txt`
- Vậy trước tiên cần tìm ra địa chỉ IP nội bộ của server FTP này
- Từ `admin.php` của Preview Service ta đã biết được server đang tương tác nãy giờ có IP là `172.29.0.4`, và netmask là `255.255.0.0`

![image](https://user-images.githubusercontent.com/42104948/205827119-b48f17e0-eabd-4926-b676-03153fb708b3.png)  

-> Để truy tìm IP nội bộ ta sẽ phải scan dãy mạng `172.29.x.y` này
- Tuy nhiên cần lưu ý đây là service FTP nên URL ta input phải có:
	- URI scheme là `ftp://` chứ không phải `http://`
	- đường dẫn muốn truy cập (`/url-path`)
	
	![image](https://user-images.githubusercontent.com/42104948/205843084-dd67a333-b1eb-4549-a9e0-a813b94f1948.png)
	
	`ftp://172.29.x.y/flag.txt`
- Cách thức thao tác trên Burp tương tự việc scan port lúc nãy, tuy nhiên range lúc này sẽ là 0-255

![image](https://user-images.githubusercontent.com/42104948/205845679-1874fcb6-0dad-4178-ae1d-17b429cb7d7f.png)

- Sau khi scan ta tìm thấy được server FTP này nằm ở IP `172.29.0.2`, và tìm được flag thứ tư
- Vậy ta đã thành công truy tìm được một server nội bộ và địa chỉ IP của nó. Không những vậy, ta còn khai thác chức năng của server này để đọc được tất cả các file mà nó đang share với các máy nội bộ khác.

# Flag 5: Đọc nội dung file `/etc/passwd` của server hiện tại
- Trong server hiện tại dĩ nhiên không có cấu hình FTP cho đọc file `/etc/passwd`
- Nếu không còn FTP, vậy có URI scheme / protocol nào cho phép ta đọc file nữa không?
- Hay cụ thể hơn, phải xem `file_get_contents` hỗ trợ các URI scheme / protocol nào?
- Đi đọc document của PHP `file_get_contents`, ta thấy có phần Tip

![image](https://user-images.githubusercontent.com/42104948/205844851-9d28a9b1-67c4-47e1-869f-58a45a66e34a.png)

- Tiếp tục xem đến Supported Protocols and Wrappers, có thể thấy ngoài `ftp://` ra, hàm `file_get_contents` còn hỗ trợ khá nhiều protocol khác

![image](https://user-images.githubusercontent.com/42104948/205844929-2f5dc844-2435-4da9-8671-366cb635eeba.png)

- Thử ngay `file://` đầu tiên vì cho phép truy cập các file nội bộ, mà mục tiêu của mình đang là `/etc/passwd`
- Dùng `file://` để đọc `/etc/passwd` và lấy được flag thứ năm, ta có thể bỏ qua phần host vì mặc định nó đã là `localhost`  
	`file:///etc/passwd`

![image](https://user-images.githubusercontent.com/42104948/205845403-d4fc779e-fd11-4074-9df2-23aef7e22eca.png)

- Vậy ta đã thành công đọc được một file bất kì nếu biết đường dẫn cụ thể của nó trên server.

# Flag 6: Đọc nội dung của file `hidden_feature.php`
- Một điểm hạn chế của `file://` protocol là cần phải truyền vào absolute path của file
- Vì vậy nếu pentest Black box không thể dùng `file://` protocol để đọc file `hidden_feature.php` được do chưa biết được DocumentRoot
- Nếu vậy, quay trở về danh sách lúc nãy, liệu còn có URI scheme / protocol nào khác để đọc file trên server mà không cần absolute path không?
- Theo thứ tự từ trên xuống thì mình đã thử 3 cái đầu rồi, vậy tới cái thứ tư `php://`

![image](https://user-images.githubusercontent.com/42104948/205844929-2f5dc844-2435-4da9-8671-366cb635eeba.png)

- Sau khi xem qua document thì mình thấy trong phần ví dụ

![image](https://user-images.githubusercontent.com/42104948/205846067-06114cfd-ed17-448c-8944-861432244498.png)

- À hóa ra có thể tận dụng `php://filter` vì nó hoạt động tương tự hàm `readfile()`, hàm này cũng cho phép dùng relative path nữa
- Vậy thử với `index.php` xem sao  
	`php://filter/resource=index.php`

![image](https://user-images.githubusercontent.com/42104948/206138770-d9c4fa8b-8a05-4aa1-9810-c5b56e955e4e.png)

- Có vẻ `php://filter` này dùng được nè, vậy thử với file `hidden_feature.php` luôn  
	`php://filter/resource=hidden_feature.php`

![image](https://user-images.githubusercontent.com/42104948/205846637-bb9d213e-33ae-48ec-8269-5eff51fb87af.png)

- Vậy ta đã thành công đọc được nội dung file trong DocumentRoot mà không cần phải biết đường dẫn DocumentRoot. Không những vậy, ta còn có thể Path Traversal ra ngoài để đọc file bất kì mà không cần biết absolute path.

![image](https://user-images.githubusercontent.com/42104948/205846893-37787c7a-47d6-4d55-9735-e4d6ccc7ebb0.png)

