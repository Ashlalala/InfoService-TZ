# InfoService-TZ
Тестовое задание для InfoService

# Setup
    
## Back-end setup 
In the back end directory: 



### in /app/Models/User.php you need to set $frontendURL to your front-end url in the sendPasswordResetNotification function:

    public function sendPasswordResetNotification($token)
    {
        $email = urlencode($this->email);
        
        $frontendURL = 'http://localhost:8080'; // set the front end link here

        $url = $frontendURL . '/reset-password?token=' . $token . '&email=' . $email;     

        $this->notify(new ResetPasswordNotification($url));
    }
