

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


Compatibility
-------------

The following listing shows our  **test results**. We have tested the
extensions and different spam checks with the recent TYPO3 versions.

"n/i" means that there is no check implemented.

- **comments**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - sessionCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - httpCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - uniqueCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - nameCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - honeypotCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - akismetCheck: 4.5 - 4.7 - 6.0 - 6.1

- **default mailform (core, old)**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0 - 6.2
  
  - sessionCheck: 6.2
  
  - httpCheck: 4.5 - 4.7 - 6.0 - 6.2
  
  - uniqueCheck: 4.5 - 4.7 - 6.0 - 6.2
  
  - nameCheck: n/i
  
  - honeypotCheck: 4.5 - 4.7 - 6.0 - 6.2
  
  - akismetCheck: n/i

- **default mailform (sysext tx\_form)**
  
  - blacklistCheck: 4.7 - 6.0 - 6.2
  
  - sessionCheck: n/i
  
  - httpCheck: 4.7 - 6.0 - 6.2
  
  - uniqueCheck: n/i
  
  - nameCheck: n/i
  
  - honeypotCheck: 4.7 - 6.0 - 6.2
  
  - akismetCheck: 6.2

- **direct\_mail\_subscription**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - sessionCheck: n/i
  
  - httpCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - uniqueCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - nameCheck: n/i
  
  - honeypotCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - akismetCheck: n/i

- **formhandler**

  - blacklistCheck: 6.2

  - httpCheck: 6.2

  - uniqueCheck: 6.2

  - honeypotCheck: 6.2

  - akismetCheck: 6.2

- **ke\_userregister**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - sessionCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - httpCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - uniqueCheck: n/i
  
  - nameCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - honeypotCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - akismetCheck: 4.5 - 4.7 - 6.0 - 6.1

- **pbsurvey**
  
  - blacklistCheck: 4.7
  
  - sessionCheck: 4.7
  
  - httpCheck: 4.7
  
  - uniqueCheck: n/i
  
  - nameCheck: n/i
  
  - honeypotCheck: 4.7
  
  - akismetCheck: n/i

- **powermail 1.x**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0
  
  - sessionCheck: 4.5 - 4.7 - 6.0
  
  - httpCheck: 4.5 - 4.7 - 6.0
  
  - uniqueCheck: 4.5 - 4.7 - 6.0
  
  - nameCheck: n/i
  
  - honeypotCheck: 4.5 - 4.7 - 6.0
  
  - akismetCheck: 4.5 - 4.7 - 6.0

- **powermail 2.x**
  
  - blacklistCheck: 6.2
  
  - sessionCheck: n/i
  
  - httpCheck: n/i
  
  - uniqueCheck: n/i
  
  - nameCheck: n/i
  
  - honeypotCheck: n/i
  
  - akismetCheck: 6.2

- **ve\_guestbook**
  
  - blacklistCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - sessionCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - httpCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - uniqueCheck: n/i
  
  - nameCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - honeypotCheck: 4.5 - 4.7 - 6.0 - 6.1
  
  - akismetCheck: 4.5 - 4.7 - 6.0 - 6.1

- **t3\_blog**
  
  - blacklistCheck: n/i
  
  - sessionCheck: n/i
  
  - httpCheck: 4.7
  
  - uniqueCheck: n/i
  
  - nameCheck: n/i
  
  - honeypotCheck: n/i
  
  - akismetCheck:4.7