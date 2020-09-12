# BML CONSOLE

BML Console for nerds 🧙‍♂️🔥 Thats it pretty much it really. Note that this is an experimental project.

I am still working on this project and its not fully finished.


## Installation

```
composer global require jinas/bml-console
```

## Usage

After installing the application globally using composer. You can run `bml-console` anywhere in your commandline. 

Make sure to place Composer's system-wide vendor bin directory in your $PATH so the bml-console executable can be located by your system. 

- macOS: `$HOME/.composer/vendor/bin`
- Windows: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`
- GNU / Linux Distributions: `$HOME/.config/composer/vendor/bin or $HOME/.composer/vendor/bin`


## Commands

All available commands will have autocompletion.

- /total : Get Total available account balance.
- /contacts : Get a table of contacts added to the bml account.
- /todays-transactions : Get a table of transactions made today.
- /pending-transactions : Get the pending transactions.
- /transactions-between : Get the transactions between the dates.
- /activities : Get a table of recent activities occured in the account.
- /exist: Exist the app


## Todo

- [ ] Ability to add contacts
- [ ] Ability to delete contacts

- [ ] Ability to make transfers to account saved in contacts.

