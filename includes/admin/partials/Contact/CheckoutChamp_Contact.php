<?php

namespace CheckoutChamp\Includes\Admin\Partials\Contact;

if (!defined('ABSPATH')) exit;

class CheckoutChamp_Contact
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_submenu'));
    }

    public function add_submenu()
    {
        add_submenu_page(
            'checkout_champ',
            'Contact Settings',
            'Contact',
            'manage_options',
            'checkout_champ_gcontact',
            array($this, 'submenu_page')
        );
    }


    public function submenu_page()
    {

        if (!current_user_can('manage_options')) {
            return;
        }

?>
        <div class="wrap">
            <div class="checkout-champ-contact">
                <div class="checkout-champ-contact-infos">
                    <h2 class="checkout-champ-contact-title">Contact Us</h2>
                    <p class="checkout-champ-contact-info">We are here to help with any questions you may have. Please reach out to us.</p>
                  <p class="checkout-champ-contact-info">
  Email: <a href="mailto:wecare@checkoutchamp.com">wecare@checkoutchamp.com</a>
</p>
                    <p class="checkout-champ-contact-info">Phone: <a href="tel:+1 (888) 733-4330">+1 (888) 733-4330</a></p>
                </div>
                <div class="checkout-champ-footer">

                    <img class="CCR_img" src="https://checkout-api.com/assets/checkout_champ_logo.png" alt="checkout champ logo" />
                    <div class="checkout-champ-footer-social-logo">
                        <a href="https://www.linkedin.com/company/checkout-champ/" class="text-brand-orange hover:text-brand-blue scale-110 flex items-center justify-center">
                            <span class="sr-only">LinkedIn</span>
                            <svg fill="currentColor" viewBox="0 0 45 45" class="h-6 w-6 " aria-hidden="true">
                                <path xmlns="http://www.w3.org/2000/svg" d="M32.229,10C39.436,10,40,10.564,40,17.77v14.507C40,39.439,39.44,40,32.277,40H17.723C10.56,40,10,39.439,10,32.277V17.723 C10,10.56,10.56,10,17.723,10H32.229z M19.771,33.25V21.046h-3.793V33.25H19.771z M17.876,19.3c1.219,0,2.21-0.991,2.21-2.212 c0-1.219-0.991-2.21-2.21-2.21c-1.222,0-2.212,0.99-2.212,2.21S16.653,19.3,17.876,19.3z M34,33.25v-6.693 c0-3.286-0.71-5.814-4.55-5.814c-1.845,0-3.082,1.012-3.588,1.971H25.81v-1.668h-3.639V33.25h3.79v-6.038 c0-1.592,0.303-3.133,2.277-3.133c1.945,0,1.971,1.821,1.971,3.236v5.935H34z"></path>
                            </svg></a><a href="https://www.facebook.com/Checkoutchamp/" class="text-brand-orange hover:text-brand-blue scale-110 flex items-center justify-center">
                            <span class="sr-only">Facebook
                            </span>
                            <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6 " aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd">
                                </path>
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/channel/UC9dpyiDLKN06MxNUxXN2sDg/videos" class="text-brand-orange hover:text-brand-blue scale-110 flex items-center justify-center">
                            <span class="sr-only">YouTube
                            </span>
                            <svg fill="currentColor" viewBox="0 0 45 45" class="h-6 w-6 " aria-hidden="true">
                                <path xmlns="http://www.w3.org/2000/svg" d="M42.042,13.856C43.773,15.577,44,18.311,44,25s-0.227,9.423-1.958,11.144C40.311,37.864,38.508,38,25,38 S9.689,37.864,7.958,36.144S6,31.689,6,25s0.227-9.423,1.958-11.144S11.492,12,25,12S40.311,12.136,42.042,13.856z M21.76,30.933 l9.717-5.63L21.76,19.76V30.933z">
                                </path>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/checkout.champ/" class="text-brand-orange hover:text-brand-blue scale-110 flex items-center justify-center">
                            <span class="sr-only">Instagram
                            </span>
                            <svg fill="currentColor" viewBox="0 -5 55 59" class="h-6 w-6 " aria-hidden="true">
                                <path xmlns="http://www.w3.org/2000/svg" d="M 16 3 C 8.83 3 3 8.83 3 16 L 3 34 C 3 41.17 8.83 47 16 47 L 34 47 C 41.17 47 47 41.17 47 34 L 47 16 C 47 8.83 41.17 3 34 3 L 16 3 z M 37 11 C 38.1 11 39 11.9 39 13 C 39 14.1 38.1 15 37 15 C 35.9 15 35 14.1 35 13 C 35 11.9 35.9 11 37 11 z M 25 14 C 31.07 14 36 18.93 36 25 C 36 31.07 31.07 36 25 36 C 18.93 36 14 31.07 14 25 C 14 18.93 18.93 14 25 14 z M 25 16 C 20.04 16 16 20.04 16 25 C 16 29.96 20.04 34 25 34 C 29.96 34 34 29.96 34 25 C 34 20.04 29.96 16 25 16 z">
                                </path>
                            </svg>

                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php

    }
}
