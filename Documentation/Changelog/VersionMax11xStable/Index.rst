

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


Version max. 1.1.x stable
^^^^^^^^^^^^^^^^^^^^^^^^^


Update on 2013-11-12 to version 1.1.1 stable
""""""""""""""""""""""""""""""""""""""""""""

- [FEATURE] #50903 - Use wt\_spamshield old mailform on TYPO3 >= 4.6
  (add static template)

- [BUGFIX] #52455 - Redirect and log doesn't work in 6.1.4+

- [BUGFIX] #51281 - Missing argument 1 for
  tx\_wtspamshield\_method\_httpcheck::validate()

- [TASK] - update of manual


Update on 2013-06-24 to version 1.1.0 stable
""""""""""""""""""""""""""""""""""""""""""""

- [FEATURE] #49392 - Configurable spam rate for each extension

- [FEATURE] - logging - useful title in the backend list view

- [FEATURE] - TYPO3 coding standards

- [FEATURE] - show error messages in email

- [FEATURE] - error with direct\_mail\_subscription

- [FEATURE] - ke\_userregister compatibility (TYPO3 6.1)

- [TASK] - test all extension and all checks with TYPO3 4.5, 4.7, 6.0, 6.1
  with Selenium 2

- [TASK] - remove extensions abstract/ move functions to
  tx\_wtspamshield\_div

- [TASK] - add getExtConf to tx\_wtspamshield\_div

- [TASK] - get TypoScript configuration from tx\_wtspamshield\_div

- [CLEANUP] - code cleanup

- [BUGFIX] #48740 - Redirect for ve\_guestbook does not work under T3 6.1

- [BUGFIX] #48622 - Call to undefined method GeneralUtility::readLLXMLfile()

- [BUGFIX] #47454 - wt\_spamshield and comments: No function?!

- [BUGFIX] - logging - useful title in the backend list view

- [BUGFIX] - strip tags in errormessage log

- [BUGFIX] - getDiv() calls