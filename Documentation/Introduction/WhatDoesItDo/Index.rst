

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


What does it do?
^^^^^^^^^^^^^^^^

- wt\_spamshield is a passive anti-spam extension for TYPO3 forms and
  works without annoying captchas.

- wt\_spamshield can be integrated in the default TYPO3 mailform (old and
  new version), powermail 1.x and 2.x, comments, ve\_guestbook, t3\_blog,
  direct\_mail\_subscription, ke\_userregister, pbsurvey and formhandler.

- wt\_spamshield uses the following checks against spam (you can enable
  or disable each check globally):

  - **Name check:** Checks if last name == first name (easy but
    effective).

  - **Link check:** You can configure how many links are allowed within a
    message.

  - **Unique check:** Similar to the name check. All fields are checked
    for duplicate entries.

  - **Honeypot check:** A non-visible input field is added to your form.
    If the field is filled the message is handled as spam.

  - **Session check:** As soon as a form is generated a timestamp is
    stored in the session. Only if this timestamp is available during the
    submit process the database entry will follow.

  - **Time (session) check:** You can define a time frame in which the
    submit process is not handled as spam (default: min. 10 sec, max. 10
    min).

  - **Akismet check:** Akismet is a reliable and powerful online check to
    determine if a message is spam.

  - **Blacklist:** You can set up IP or email blacklists.

- If wt\_spamshield detects spam a notification email can be send to the
  admin; maybe to check if everything works as expected. wt\_spamshield
  can also log each spam detection in the database.

**IMPORTANT:** If you have ideas for extension improvements write an
email and support fighting spam!