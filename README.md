# VSDb (Very Secure Database)

VSDb (Very Secure Database) is a nimble cryptographic database that doesn't store it's key anywhere online or offline. Instead of key-matching, VSDb attempts to decrypt the databse with a user-provided key. Any failure to decrypt delivers an error and restricts access. To keep your data as secure as possible, it is recommended that you only share your key through face-to-face communication with people you trust.

## Installation

VSDb does not currently include an auto-install file. To install manually:

* Create an SQL database with two tables (ver and data). To ver, add one row (called "A") and place your key in it (your key will be made with keymaker.php as explained below). To data, add an incremental ID row and the following text rows: N, P, A, C, S, R, G.
* Update read.php and add.php with the correct SQL database login information.
* Use keymaker.php to produce a key with your unqiue password. Place this hash in the SQL table ver, row A.
* You are now ready to login through index.html and begin adding entries to your database!

## Contact

Feel free to [email me](mailto:jnabasny@gmail.com) with any questions or comments!

Encrypted email is preferred. Here is my public key:
```
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1

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
=t+nP
-----END PGP PUBLIC KEY BLOCK-----
```