.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


General configuration and considerations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

With the help of the TypoScript constants you can configure the
following settings  **for each supported extension** :

- Which spam checks should be applied? As you can see from
  the listing above the different extensions do not support all of the
  implemented checks.

- How many positive spam checks are needed to mark the submitted entry
  as spam? By default only 1 check has to fail.

Furthermore you can configure some settings globally. Before
wt\_spamshield 1.2.0 this was done within the extension manager (see
settings below).

General configuration
"""""""""""""""""""""

The following configuration can be set via TypoScript constants.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Title
         logging.notificationAddress

   Default value
         n/a

   Description
         Enter an email address if you would like to receive an email if spam
         was recognized (e.g. email@domain.org).

.. container:: table-row

   Title
        logging.pid

   Default value
         0

   Description
         Enter a PID for saving spam log entries (-2 for current page, -1
         deactivates logging, 0 for root page, 1 for PID 1 etc.).

.. container:: table-row

   Title
         comments

   Default value
         0

   Description
         Enable spamshield for comments

.. container:: table-row

   Title
         mailform

   Default value
         0

   Description
         Enable spamshield for default mailform

.. container:: table-row

   Title
         direct\_mail\_subscription

   Default value
         0

   Description
         Enable spamshield for direct\_mail\_subscription

.. container:: table-row

   Title
         ke\_userregister

   Default value
         0

   Description
         Enable spamshield for ke\_userregister

.. container:: table-row

   Title
         powermail

   Default value
         0

   Description
         Enable spamshield for powermail (version 1.x)

.. container:: table-row

   Title
         powermail2

   Default value
         0

   Description
         Enable spamshield for powermail (version 2.x)

.. container:: table-row

   Title
         t3\_blog

   Default value
         0

   Description
         Enable spamshield for t3\_blog

.. container:: table-row

   Title
         ve\_guestbook

   Default value
         0

   Description
         Enable spamshield for ve\_guestbook

.. container:: table-row

   Title
         pbsurvey

   Default value
         0

   Description
         Enable spamshield for pbsurvey

.. container:: table-row

   Title
         formhandler

   Default value
         0

   Description
         Enable spamshield for formhandler

.. container:: table-row

   Title
         validators.standardMailform\_new.enable

   Default value
         blacklistCheck, httpCheck, honeypotCheck

   Description
         validators for standardMailform >= TYPO3 4.6:

.. container:: table-row

   Title
         validators.standardMailform\_new.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for standardMailform >= TYPO3 4.6, i.e. how many
         validators can fail

.. container:: table-row

   Title
         validators.standardMailform\_old.enable

   Default value
         blacklistCheck, httpCheck, uniqueCheck, sessionCheck, honeypotCheck

   Description
         validators for standardMailform <= TYPO3 4.5

.. container:: table-row

   Title
         validators.standardMailform\_old.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for standardMailform <= TYPO3 4.5, i.e. how many
         validators can fail

.. container:: table-row

   Title
         validators.powermail.enable

   Default value
         blacklistCheck, sessionCheck, httpCheck, uniqueCheck, honeypotCheck, akismetCheck

   Description
         validators for powermail

.. container:: table-row

   Title
         validators.powermail.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for powermail, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.powermail2.enable

   Default value
         blacklistCheck, akismetCheck

   Description
         validators for powermail2

.. container:: table-row

   Title
         validators.powermail2.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for powermail2, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.ve\_guestbook.enable

   Default value
         blacklistCheck, nameCheck, sessionCheck, httpCheck, honeypotCheck, akismetCheck

   Description
         validators for ve\_guestbook

.. container:: table-row

   Title
         validators.ve\_guestbook.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for ve\_guestbook, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.comments.enable

   Default value
         blacklistCheck, nameCheck, httpCheck, sessionCheck, honeypotCheck, akismetCheck

   Description
         validators for comments

.. container:: table-row

   Title
         validators.comments.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.t3\_blog.enable

   Default value
         httpCheck, akismetCheck

   Description
         validators for t3\_blog

.. container:: table-row

   Title
         validators.t3\_blog.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.direct\_mail\_subscription.enable

   Default value
         blacklistCheck, httpCheck, uniqueCheck, honeypotCheck

   Description
         validators for direct\_mail\_subscription

.. container:: table-row

   Title
         validators.direct\_mail\_subscription.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.ke\_userregister.enable

   Default value
         validators for ke\_userregister

   Description
         blacklistCheck, nameCheck, httpCheck, sessionCheck, honeypotCheck, akismetCheck

.. container:: table-row

   Title
         validators.ke\_userregister.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.pbsurvey.enable

   Default value
         httpCheck, sessionCheck, honeypotCheck, blacklistCheck

   Description
         validators for pbsurvey

.. container:: table-row

   Title
         validators.pbsurvey.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         validators.formhandler.enable

   Default value
         blacklistCheck, httpCheck, uniqueCheck, honeypotCheck, akismetCheck

   Description
         validators for formhandler

.. container:: table-row

   Title
         validators.formhandler.how\_many\_validators\_can\_fail

   Default value
         0

   Description
         failure rate for comments, i.e. how many validators can fail

.. container:: table-row

   Title
         redirect\_mailform

   Default value
         n/a

   Description
         Mailform Redirect: Redirect URL for default mailform

.. container:: table-row

   Title
         redirect\_ve\_guestbook

   Default value
         n/a

   Description
         ve\_guestbook Redirect: Redirect PID for ve\_guestbook

.. container:: table-row

   Title
         httpCheck.maximumLinkAmount

   Default value
         3

   Description
         Set the maximum number of links (http, https, ftp) within a message.
         If you want to allow 3 links enter "3". If you want no links at all
         enter "0".

.. container:: table-row

   Title
         uniqueCheck.fields

   Default value
         n/a

   Description
         Enter different field names (separated by comma) which should not be
         equal. Example for powermail: uid1 = first name and uid2 = last name
         -> "uid1,uid2". You can add more than one condition by splitting them
         with semicolons. Example for powermail: uid1 = first name, uid2 = last
         name, uid3 = address, uid1 and uid3 should not be equal as well as
         uid2 and uid3 should not be equal but uid1 and uid2 can be equal ->
         "uid1,uid3[semicolon]uid2,uid3".

.. container:: table-row

   Title
         akismetCheck.akismetKey

   Default value
         n/a

   Description
         Enter your Akismet key to activate Akismet check (signup at
         https://akismet.com/signup/).

         **Attention** If you are planning to use Akismet for a German
         website or the owner of the website has to comply German law
         please check out the following website: http://faq.wpde.org/hinweise-zum-datenschutz-beim-einsatz-von-akismet-in-deutschland/.
         The usage of Akismet is problematic and the proper integration has to
         be handled by the administrator/ owner of the website. The
         extension wt\_spamshield does not integrate any privacy note
         or checkbox (as requested by the above mentioned article).

.. container:: table-row

   Title
         akismetCheck.testMode

   Default value
         0

   Description
         Enable the akismet test mode by changing the value to 1. This will send
         is\test=1 to Akismet.

.. container:: table-row

   Title
         sessionCheck.sessionStartTime

   Default value
         10

   Description
         Minimum time frame between entering the form page and submiting the
         form. 0 for disable.

.. container:: table-row

   Title
         sessionCheck.sessionEndTime

   Default value
         600

   Description
         Maximum time frame between entering the form page and submiting the
         form. 0 for disable.

.. container:: table-row

   Title
         honeypot.css.inputStyle

   Default value
         style="position:absolute; margin:0 0 0 -999em;"

   Description
         CSS style for honeypot input field

.. container:: table-row

   Title
         honeypot.css.inputClass

   Default value
         class="wt\_spamshield\_field wt\_spamshield\_honey"

   Description
         CSS class for honeypot input field

.. container:: table-row

   Title
         honeypot.additionalParams.standard

   Default value
         autocomplete="off"

   Description
         additional tag params for honeypot input field

.. container:: table-row

   Title
         honeypot.additionalParams.html5

   Default value
         tabindex="-1"

   Description
         Additional tags params for honeypot input field when using HTML5 as doctype.

         The standard additional params will always be rendered
         (honeypot.additionalParams.standard). If you're using HTML5 as doctype
         the value of honeypot.additionalParams.html5 is rendered as well. If
         you are not using HTML5 as doctype you can easily add the tabindex
         setting to honeypot.additionalParams.standard in your own constants.
         Please consider that negative values for tabindex are only valid in
         HTML5. Even if it does not validate in XHTML or HTML < 5 newer
         browsers will understand it.

.. container:: table-row

   Title
         honeypot.inputname.comments

   Default value
         uid987651

   Description
         Honeypot input name for comments

.. container:: table-row

   Title
         honeypot.inputname.direct\_mail\_subscription

   Default value
         uid987651

   Description
         Honeypot input name for direct\_mail\_subscription

.. container:: table-row

   Title
         honeypot.inputname.standardMailform

   Default value
         uid987651

   Description
         Honeypot input name for standardMailform

.. container:: table-row

   Title
         honeypot.inputname.powermail

   Default value
         uid987651

   Description
         Honeypot input name for powermail

.. container:: table-row

   Title
         honeypot.inputname.ve\_guestbook

   Default value
         uid987651

   Description
         Honeypot input name for ve\_guestbook

.. container:: table-row

   Title
         honeypot.inputname.ke\_userregister

   Default value
         uid987651

   Description
         Honeypot input name for ke\_userregister

.. container:: table-row

   Title
         honeypot.inputname.pbsurvey

   Default value
         uid987651

   Description
         Honeypot input name for pbsurvey

.. container:: table-row

   Title
         honeypot.inputname.formhandler

   Default value
         uid987651

   Description
         Honeyput input name for formhandler


.. ###### END~OF~TABLE ######

The following screenshot shows some settings of wt\_spamshield within
the Constant Editor.

|img-6|


Example for powermail 1.x
"""""""""""""""""""""""""

::

   plugin.wt_spamshield {
     validators.powermail.enable = blacklistCheck, sessionCheck, httpCheck, honeypotCheck, akismetCheck
     validators.powermail.how_many_validators_can_fail = 1
   }

The example above configures the integration of powermail 1.x. By
default the following checks are available: blacklistCheck,
sessionCheck, httpCheck, uniqueCheck, honeypotCheck, akismetCheck. In
the example we have removed the uniqueCheck. Furthermore we have risen
the number of positive spam checks (how\_many\_validators\_can\_fail).
Now 2 checks have to fail in order to mark the entry as spam.