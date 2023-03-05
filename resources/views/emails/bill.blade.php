<div class="navigation">
    <div class="logo">
        <img src="{{ config('app.app') . '/_nuxt/assets/images/logo.png'  }}" width="40px" height="49px">
        <span class="logo-text" style="font-size: 24px;color: #E2571C;font-family: Arial, serif;">Lossesly</span>
    </div>
</div>

<div class="header">
    <h1>Sveiks, {{ $user_job->user->name }}!</h1>
    <p>Tev ir pienācis rēķins no {{ $user_job->expert->name }} {{ $user_job->expert->surname }}</p>
</div>

<div class="bill">
    <h1>Rēķins</h1>
    <div>
        <div>
            <strong><h4>Kods:</h4></strong>
            <p>{{ $user_job->id }}</p>
        </div>
        <div>
            <strong><h4>Problēma:</h4></strong>
            <p>{{ $user_job->job_name }}</p>
        </div>
        <div>
            <strong><h4>Eksperts:</h4></strong>
            <p>{{ $user_job->expert->name }} {{ $user_job->expert->surname }}</p>
        </div>
        <div>
            <strong><h4>Pasūtītājs:</h4></strong>
            <p>{{ $user_job->user->name }} {{ $user_job->user->surname }}</p>
        </div>
        <div>
            <strong><h4>Darbs tika pasūtīts:</h4></strong>
            <p>{{ (new \Carbon\Carbon($user_job->created_at))->format('d.m.Y') }}</p>
        </div>
        <div>
            <strong><h4>Darbs tika sākts:</h4></strong>
            <p>{{ (new \Carbon\Carbon($user_job->started))->format('d.m.Y') }}</p>
        </div>
        <div>
            <strong><h4>Darbs tika pabeigts:</h4></strong>
            <p>{{ (new \Carbon\Carbon($user_job->end))->format('d.m.Y') }}</p>
        </div>
        <div>
            <strong><h2>Cena:</h2></strong>
            <h3>{{ $user_job->price }}€</h3>
        </div>
        <p>Rēķinu vari samaksāt savā profilā</p>
    </div>

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
    .bill {
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        border: 1px solid #F98724;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        gap: 20px;
        flex-direction: column;
    }
    .bill > div {
        display: flex;
        gap: 10px;
        flex-direction: column;
    }
    .bill > div > div {
        display: flex;
        gap: 10px;
        align-items: center;
        width: 50%;
    }
</style>
