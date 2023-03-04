<div class="navigation">
    <div class="logo">
        <img src="http://localhost:3000/_nuxt/assets/images/logo.png" width="40px" height="49px">
        <span class="logo-text" style="font-size: 24px;color: #E2571C;font-family: Arial, serif;">Lossesly</span>
    </div>
</div>

<div class="header">
    <h1>Sveiks, {{ $user_job->expert->name }}!</h1>
    <p>Tev ir pienācis jauns darba piedāvājums no {{ $user_job->user->name }} {{ $user_job->user->surname }}</p>
    <p>Vairāk informācijas vari atrast savā profilā, pie "Darba piedāvājumi"</p>
</div>

<div class="problem">
    <h3>Problēma: {{ $user_job->job_name }}</h3>
    <p>{{ $user_job->job_description }}</p>
</div>

<style>
    * {
        font-family: Arial, serif;
        margin: 0;
        padding: 0;
    }
    h1 {
        color: #F98724;
    }
    h3, p, h1 {
        margin: 0;
        padding: 0;
    }
    .header {
        margin-bottom: 30px;
    }
    .problem {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .problem > p {
        padding: 10px;
    }
    .logo {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .navigation {
        display: flex;
        position: relative;
        justify-content: space-between;
        align-items: center;
        padding: 8px 32px;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        z-index: 2;
        margin-bottom: 16px;
    }
</style>
