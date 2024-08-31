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
                Livewire.dispatch('formSubmitted',{ token:token });
            });
        },
    }">
     @csrf
    @if(session()->has('success'))
        <h5 class="alert alert-success text-left">
            {{ session()->get('success') }}
        </h5>
    @endif
    @error('recaptcha')
        <h5 class="alert alert-danger text-left" role="alert">{{ $message }}</h5>
    @enderror
    
    <input type="text" class="name" name="name" placeholder="NAME" wire:model="name"><br>
    @error('name')
        <h5 class="alert alert-danger" role="alert">
            {{$message}}
        </h5>
    @enderror
    <input type="email" class="email" name="email" placeholder="EMAIL" wire:model="email"><br>
    @error('email')
        <h5 class="alert alert-danger" role="alert">
            {{$message}}
        </h5>
    @enderror
    <textarea class="msg" name="message" placeholder="MESSAGE" wire:model="message"></textarea>
    @error('message')
        <h5 class="alert alert-danger" role="alert">
            {{$message}}
        </h5>
    @enderror
    <button class="btn" type="submit">SEND MESSAGE</button>




</form>
 

