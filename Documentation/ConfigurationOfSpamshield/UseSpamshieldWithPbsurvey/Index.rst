

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


Use wt\_spamshield with pbsurvey
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The support of this extension was introduced in version 1.2.0. In
order to integrate wt\_spamshield with pbsurvey create a new
questionaire item called "Call User Defined Hook".

The author of pbsurvey had to implement a new hook inside pbsurvey.
When writing this document the new version was not available via TER.
You can download the new version here:
https://github.com/tritumRz/pbsurvey


Add TypoScript Constants
""""""""""""""""""""""""

::

   plugin.wt_spamshield.pbsurvey = 1


TypoScript explanation
""""""""""""""""""""""

With the setting in the constants you can enable or disable the plugin
on different pages.