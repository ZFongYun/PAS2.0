## 同儕互評系統(2.0版)
此系統提供使用者在會議中能夠透過手機給予同儕即時性的回饋。

### 安裝
1. 在terminal輸入`https://github.com/ZFongYun/PAS2.0.git`下載專案資料夾
2. 開啟專案，複製`.env .example`成新增`.env`，接著設定資料庫相關環境變數
3. 在terminal輸入`php artisan key:generate`，以建立`.env`的`APP_KEY`
4. 在terminal輸入`php artisan migrate`，遷移資料表至資料庫
5. 在terminal輸入`php artisan db:seed --class=`，將教師帳號新增至資料表中

### 系統架構
![PAS](https://user-images.githubusercontent.com/53658361/176619329-7573a65a-1107-4ede-8b28-25bc38f36db3.png)

此系統的主要使用者分別為二種，第一種為教師，第二種為學生。教師與學生可以在電腦或行動裝置開啟瀏覽器並輸入系統網址後，即可進入同儕互評系統。

### 使用技術
* HTML/CSS
* RWD(Bootstrap)
* PHP(Laravel)
* JavaScript (jQuery)
* 套件：[Middleware](https://github.com/SpartnerNL/Laravel-Excel)

### 開發功能
* 管理團隊成員資料
* 管理會議資料
* 同儕互評
* 檔案上傳/下載
