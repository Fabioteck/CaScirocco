fabio@soundserver:~$ sudo certbot --apache -d soundsystemculture.social -d www.soundsystemculture.social
Saving debug log to /var/log/letsencrypt/letsencrypt.log
Enter email address (used for urgent renewal and security notices)
 (Enter 'c' to cancel): frigeriwki@gmail.com

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Please read the Terms of Service at
https://letsencrypt.org/documents/LE-SA-v1.6-August-18-2025.pdf. You must agree
in order to register with the ACME server. Do you agree?
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
(Y)es/(N)o: y

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Would you be willing, once your first certificate is successfully issued, to
share your email address with the Electronic Frontier Foundation, a founding
partner of the Let's Encrypt project and the non-profit organization that
develops Certbot? We'd like to send you email about our work encrypting the web,
EFF news, campaigns, and ways to support digital freedom.
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
(Y)es/(N)o: y
Account registered.
Requesting a certificate for soundsystemculture.social and www.soundsystemculture.social

Successfully received certificate.
Certificate is saved at: /etc/letsencrypt/live/soundsystemculture.social/fullchain.pem
Key is saved at:         /etc/letsencrypt/live/soundsystemculture.social/privkey.pem
This certificate expires on 2026-06-10.
These files will be updated when the certificate renews.
Certbot has set up a scheduled task to automatically renew this certificate in the background.

Deploying certificate
Successfully deployed certificate for soundsystemculture.social to /etc/apache2/sites-available/hub-le-ssl.conf

We were unable to find a vhost with a ServerName or Address of www.soundsystemculture.social.
Which virtual host would you like to choose?
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
1: hub.conf                       |                       |       | Enabled
2: hub-le-ssl.conf                | soundsystemculture.so | HTTPS | Enabled
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Select the appropriate number [1-2] then [enter] (press 'c' to cancel): 2
Successfully deployed certificate for www.soundsystemculture.social to /etc/apache2/sites-available/hub-le-ssl.conf
Congratulations! You have successfully enabled HTTPS on https://soundsystemculture.social and https://www.soundsystemculture.social

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
If you like Certbot, please consider supporting our work by:
 * Donating to ISRG / Let's Encrypt:   https://letsencrypt.org/donate
 * Donating to EFF:                    https://eff.org/donate-le
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
fabio@soundserver:~$ 

fabio@soundserver:~$ sudo certbot --apache -d soundsystemculture.social -d www.soundsystemculture.social
Saving debug log to /var/log/letsencrypt/letsencrypt.log
Certificate not yet due for renewal

You have an existing certificate that has exactly the same domains or certificate name you requested and isn't close to expiry.
(ref: /etc/letsencrypt/renewal/soundsystemculture.social.conf)

What would you like to do?
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
1: Attempt to reinstall this existing certificate
2: Renew & replace the certificate (may be subject to CA rate limits)
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Select the appropriate number [1-2] then [enter] (press 'c' to cancel): 1
Deploying certificate
Successfully deployed certificate for soundsystemculture.social to /etc/apache2/sites-enabled/hub-le-ssl.conf
Successfully deployed certificate for www.soundsystemculture.social to /etc/apache2/sites-enabled/hub-le-ssl.conf
Congratulations! You have successfully enabled HTTPS on https://soundsystemculture.social and https://www.soundsystemculture.social

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
If you like Certbot, please consider supporting our work by:
 * Donating to ISRG / Let's Encrypt:   https://letsencrypt.org/donate
 * Donating to EFF:                    https://eff.org/donate-le
- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
fabio@soundserver:~$ 

