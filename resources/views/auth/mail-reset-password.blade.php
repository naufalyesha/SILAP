<style>
    .reset-password-heading {
        font-size: 24px;
        color: #184796;
        text-align: center;
        margin-bottom: 20px;
    }

    .reset-password-link {
        display: inline-block;
        padding: 10px 20px;
        background-color: #184796;
        color: #fff;
        text-decoration: none;
        font-size: 18px;
        text-align: center;
        border-radius: 8px;
        transition: background-color 0.4s, color 0.4s;
    }

    .reset-password-link:hover {
        background-color: #143e6e;
        color: #fff;
    }
</style>

<h4>Klik link di bawah untuk Reset Password!</h4>
<br>
<br>
<a href="{{ route('validate-forgot-password', ['token' => $token]) }}">Klik di sini!</a>
