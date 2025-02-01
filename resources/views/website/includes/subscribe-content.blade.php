<div class="sidebar widget p-0" aria-label="Subscription form">
    <div class="subscribe-header-color text-center p-2 pt-3">
        <i><img  src="{{asset('img\mail.png')}}" alt="subscribe mail" aria-label="subscribe mail"></i>
        <p class="sidebar-title subscribe-title-font color-white py-2">Subscribe Today!</p>
        <p class="font-size-14 color-white">Join our mailing list to receive latest updates and news</p>


    </div>


    <div class="Subscribe-box p-3">
        <form id="subscribe-form">
            <div class="mb-3">
                <input id="subscribe" type="email" class="form-contact" name="email" placeholder="example@example.com"
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            </div>
            <div class="mb-3">
                <input type="submit" name="submitNewsletter" class="btn btn-block transition-background" value="Subscribe">
            </div>
        </form>
    </div>
</div>
