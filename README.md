# InfoService-TZ
Тестовое задание для InfoService

node --version
v21.3.0

npm --version
10.5.1


# Setup
    
## Back-end setup 

### 1. Install dependencies
    !composer install

### 2. Setup .env
    Renamle .env.example file to .env
    Open the .env and fill in your MySQL database connection details and your MailTrap (or any other SMTP) details

### 3. In back/app/Models/User.php you need to set $frontendURL to your front-end url in the sendPasswordResetNotification function:

    public function sendPasswordResetNotification($token)
    {
        $email = urlencode($this->email);
        
        $frontendURL = 'http://localhost:8080'; // set the front end link here

        $url = $frontendURL . '/reset-password?token=' . $token . '&email=' . $email;     

        $this->notify(new ResetPasswordNotification($url));
    }

### 4. In the back end directory (InfoService-TZ/back/) generate key, migrate, seed the statuses and start the server: 
    !php artisan key:generate
    !php artisan migrate 
    !php artisan db:seed --class=StatusSeeder
    !php artisan serve


## Front-end setup

### 1. In the front-end directory (InfoService-TZ/front/):
    !npm install

### 2. In front/src/axios.js you need to set the backendURL variable to your back-end url: 
    const backURL = 'http://localhost:8000'; //set your backend url here

### 3. Start the front-end server:
    !npm run serve
    (or alternatively): !npm run dev










