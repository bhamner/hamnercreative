<form id="form"  
    @submit.prevent="gCaptcha"
    x-data="{
        siteKey: @js( config('services.recaptcha_v3.siteKey') ),
        init() {
            // load our recaptcha.
            if (!window.recaptcha) {
                const script = document.createElement('script');
                script.src = 'https://www.google.com/recaptcha/api.js?render=' + this.siteKey;
                document.body.append(script);
            }
        },
        gCaptcha() {
            grecaptcha.execute(this.siteKey, {action: 'submit'}).then(token => {
                Livewire.dispatch('formSubmitted', {token: token});
            });
        },
    }">
     @csrf
    <input type="text" class="name" name="name" placeholder="NAME" required=""><br>
    @error('name')
        <p class="alert alert-danger" role="alert">
            {{$message}}
        </p>
    @enderror
    <input type="email" class="email" name="email" placeholder="EMAIL" required=""><br>
    @error('email')
        <p class="alert alert-danger" role="alert">
            {{$message}}
        </p>
    @enderror
    <textarea class="msg" name="message" placeholder="MESSAGE" required=""></textarea>
    @error('message')
        <p class="alert alert-danger" role="alert">
            {{$message}}
        </p>
    @enderror
    <button class="btn" type="submit">SEND MESSAGE</button>

    @error('recaptcha')
        <p class="alert alert-danger" role="alert">{{ $message }}</p>
    @enderror
    
    @if(session()->has('message'))
        <p class="alert alert-success">
            {{ session()->get('message') }}
        </p>
    @endif

</form>


