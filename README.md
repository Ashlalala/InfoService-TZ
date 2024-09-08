# InfoService-TZ
Тестовое задание для InfoService

node --version
v21.3.0

npm --version
10.5.1


# Setup
    
## Back-end setup 

### 1. Setup .env
    Connect your project to a mySQL database and fill in your MailTrap (or any other SMTP)

### 2. In the back end directory (InfoService-TZ/back/): 
    !php artisan migrate 
    !php artisan db:seed --class=StatusSeeder

### 3. In back/app/Models/User.php you need to set $frontendURL to your front-end url in the sendPasswordResetNotification function:

    public function sendPasswordResetNotification($token)
    {
        $email = urlencode($this->email);
        
        $frontendURL = 'http://localhost:8080'; // set the front end link here

        $url = $frontendURL . '/reset-password?token=' . $token . '&email=' . $email;     

        $this->notify(new ResetPasswordNotification($url));
    }



## Front-end setup

### 1. In the front-end directory (InfoService-TZ/front/):
    !npm install

### 2. In front/src/axios.js you need to set the baseURL variable to your back-end url in the axios.create function: 
    const instance = axios.create({
    baseURL: 'http://localhost:8000/api', // set your back-end url here
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
    }
    });











