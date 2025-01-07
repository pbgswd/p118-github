<table class="body" style="margin-top: 1rem; margin-left: auto; margin-right: auto;">
    <tr>
        <td class="wrapper last">
            <table class="body" style="width: 100%; max-width: 600px; margin: 1rem auto;">
                <tr>
                    <td class="wrapper">
                        <table class="row" style="width: 100%; padding: 10px;">
                            <tr>
                                <td style="text-align: center; font-size: 0; padding-top:2px;"> <!-- font-size: 0 removes unwanted spacing between inline-block elements -->
                                    <a href="https://x.com/118IATSE/" title="p118 on X" target="_blank" style="display: inline-block; margin: 0 10px;">
                                        <img  src="{{env('APP_URL')}}/email/x-email-icon.png" alt="X Icon" style="max-width: 50%; height: auto;" />
                                    </a>
                                    <a href="https://www.facebook.com/IATSE118/" title="p118 on FaceBook" target="_blank" style="display: inline-block; margin: 0 10px;">
                                        <img src="{{env('APP_URL')}}/email/fb-email-icon.png" alt="Facebook Icon" style="max-width: 50%; height: auto;" />
                                    </a>
                                    <a href="https://www.instagram.com/IATSE118/" title="p118 on InstaGram" target="_blank" style="display: inline-block; margin: 0 10px;">
                                        <img src="{{env('APP_URL')}}/email/insta-email-icon.png" alt="Instagram Icon" style="max-width: 50%; height: auto;" />
                                    </a>
                                    <a href="http://p118.dev" title="p118" target="_blank" style="display: inline-block; margin: 0 10px;">
                                        <img src="{{env('APP_URL')}}/email/118-email-icon.png" alt="p118 Icon" style="max-width: 50%; height: auto;" />
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <hr style="height: 3px; background-color: gray; border: none;" />
                        <p style="text-align:center; margin-top: 2rem;">
                            Copyright &copy; <?php echo date('Y'); ?> IATSE Local 118, All rights reserved.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <p style="text-align:center; margin-left: auto; margin-right: auto;">
                            <b>
                                <a href="{{env('APP_URL')}}" target="_blank" title="IATSE Local 118">
                                    {{env('APP_URL')}}
                                </a>
                            </b>
                            <br />
                            <br /> <br />
                            <b>Our Mailing address:</b><br />
                            IATSE Local 118<br />
                            #206 – 2940 Main Street<br />
                            Vancouver, BC V5T 3G3<br />
                            Canada<br />
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <a target="_blank"
                           rel="noopener noreferrer"
                           href="{{env('APP_URL')}}/email/Membership_List_5.30.19.vcf" download="file">
                            Add us to your address book.
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding-bottom:4rem;">
                        <strong>How to update my email preferences?</strong><br />
                        Log in to <a href="{{env('APP_URL')}}">{{env('APP_URL')}}</a>,
                        and go to the Message Preferences<br />
                        tab on your personal profile page.
                    </td>
                    <td class="expander"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- container end below -->
</body>
</html>
