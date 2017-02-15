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


Use wt\_spamshield with default (TYPO3) mailform
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Preface
"""""""

There are different settings regarding the TYPO3 version you are
using. In TYPO3 4.6 the default mailform extension was
completely rewritten in extbase. With the new extension called tx\_form
many things have changed and you have to configure wt\_spamshield
differently. Regardless the TYPO3 version you are using - even in
TYPO3 6.1 - it's possible to use the old default mailform (core)
instead of the sysext tx\_form. In TYPO3 7.1 the old mailform has
been moved to the compatibility6 extension.


Add a new page
""""""""""""""

Create a new page (maybe hidden in the navigation) and enter a text
which should be shown if spam was recognized.

|img-7|


Add static template (tx\_form not installed)
""""""""""""""""""""""""""""""""""""""""""""

Add the static template "Default Mailform (wt\_spamshield)". This step
is only possible if you did  **NOT** install tx\_form. If you have
installed tx\_form there will be no static template in the list.

|img-8|


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.mailform = 1
   plugin.wt_spamshield.honeypot.inputname.standardMailform = uid987651
   plugin.wt_spamshield.redirect_mailform = http://www.yourpage.com/index.php?id=14


TypoScript explanation
""""""""""""""""""""""

With the first line you can enable or disable the plugin on different
pages.

The second line defines the name of the honeypot field. This name is
especially important if you use tx\_form. If you are using the old
mailform and you want to change the name of the field also keep in
mind to adjust another TypoScript snippet. The file can be found under
/wt\_spamshield/Configuration/TypoScript/Extensions/defaultmailform/se
tup.txt. So if you want to change the name also change the innerWrap
of the following snippet. For further information see the
corresponding ticket on forge ( `http://forge.typo3.org/issues/53618
<http://forge.typo3.org/issues/53618>`_ ).

::

   tt\_content.mailform.20.stdWrap {
     innerWrap = | <input name="uid987651" type="text" autocomplete="off" style="position: absolute; margin: 0 0 0 -9999px;" value="" />
   }

With the third line you define to which URL the user will be
redirected if spam was recognized.  **Enter a fully qualified URL** !


Special field configuration (TYPO3 >= 4.6)
""""""""""""""""""""""""""""""""""""""""""

To use wt\_spamshield with tx\_form you have to configure your own
validation rules. Open the content element which stores the
configuration of the specific form. On the second tab "Form" you have
to add rule sets like the following one:

::

   ...
   30 = TEXTAREA
   30 {
     cols = 40
     rows = 5
     name = msg
     label {
       value = Message
     }
   }
   40 = TEXTLINE
   40 {
     name = uid987651
     label {
       value = Sweet pot
     }
   }
   ...
   rules {
     1 = wtspamshield
     1 {
       element = msg
     }
     2 = wtspamshield
     2 {
       element = uid987651
     }
   }

The snippet configures two fields; one for a textarea (name="msg") and
one for an input field (name="uid987651") used for the honeypot. In
the second part of the snippet we create rules for each and every
field we want to check with wt\_spamshield. Internally wt\_spamshields
processes the whole validation chain for each field you define in this
section (http check, honeypot check, Akismet etc.).

If you want to use the honeypot check you have to create the
corresponding field manually (see code snippet above) within your
form. Please make sure that the field name is also configured in
wt\_spamshield:

::

   plugin.wt_spamshield.honeypot.inputname.standardMailform = uid987651

Furthermore you have to hide the field by using CSS (we assume the
honeypot input field has the id="field-5"). Please also keep in mind
that tx\_form starts the field counter from 1 for each form/ content
element.

::

   #field-5 { position:absolute; margin:0 0 0 -999em; }