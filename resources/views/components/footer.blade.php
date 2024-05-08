<footer class="footer p-10 bg-card text-main border-t dark:border-gray-700 shadow-md mt-2">
  <nav class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-4">
    <div class="col-span-1 flex flex-col items-center mt-2 lg:mt-0">
      <div class="text-center md:text-start flex flex-col">
        <h1 class="text-xl text-main mb-1">{{ __('Services') }}</h1> 
        @if(Auth::check())
          <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('user.show', Auth::user()->id) }}">{{ __('View Your Profile') }}</a>
          <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('user.edit', Auth::user()->id) }}">{{ __('Edit Your Profile') }}</a>
          <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('user.edit', Auth::user()->id) }}">{{ __('Create a post') }}</a>
          <a class="text-muted hover:text-main hover:underline cursor-pointer">{{ __('Random Post') }}</a>
        @else
          <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('login') }}">{{ __('Login') }}</a>
          <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
      </div>
    </div>

    <div class="col-span-1 flex flex-col items-center mt-2 lg:mt-0">
      <div class="text-center md:text-start flex flex-col">
        <h1 class="text-xl text-main mb-1">{{ __('Forum') }}</h1> 
        <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('home') }}">{{ __('Home') }}</a>
        <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('about') }}">{{ __('About Us') }}</a>
        <a class="text-muted hover:text-main hover:underline cursor-pointer" href="{{ route('contact') }}">{{ __('Contact') }}</a>
      </div>
    </div>

    <div class="col-span-1 flex flex-col items-center  mt-2 lg:mt-0">
      <div class="text-center md:text-start flex flex-col">
        <h1 class="text-xl text-main mb-1">Legal</h1> 
        <p class="text-muted hover:text-main hover:underline cursor-pointer">Terms of use</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer">Privacy policy</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer">Cookie policy</p>
      </div>
    </div>

    <div class="col-span-1 flex flex-col items-center mt-2 lg:mt-0">
      <div class="text-center md:text-start flex flex-col">
        <h1 class="text-xl text-main mb-1">{{ __('Socials') }}</h1> 
        <p class="text-muted hover:text-main hover:underline cursor-pointer inline-flex gap-1 items-center"><x-lucide-twitter class="w-4 h-4 text-muted" />X</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer inline-flex gap-1 items-center"><x-lucide-facebook class="w-4 h-4 text-muted" /> Facebook</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer inline-flex gap-1 items-center"><x-lucide-instagram class="w-4 h-4 text-muted" />Instagram</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer inline-flex gap-1 items-center"><x-lucide-youtube class="w-4 h-4 text-muted" />Youtube</p>
        <p class="text-muted hover:text-main hover:underline cursor-pointer inline-flex gap-1 items-center"><x-lucide-github class="w-4 h-4 text-muted" />Github</p>
      </div>
    </div>
  </nav>
  <div class="footer px-10 text-center py-4 border-t dark:border-gray-700">
    <aside class="flex flex-col items-center text-muted">
      <p>Jovan Isailovic 101/2020</p>
      <p>&copy;Top Popular, 2024</p>
    </aside> 
  </div>
</footer>