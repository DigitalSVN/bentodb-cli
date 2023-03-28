# bentodb-cli

## Installation
```bash
composer global require digitalsvn/bentodb-cli
```

You should then be able to run the `bentodb` command from anywhere on your system.
```bash
bentodb
```
If this fails, you may also need to add the composer global bin directory to your PATH environment variable.

Find your global composer bin directory:
```bash
composer global config --list | grep bin-dir
```

Add to your path (use the result of the command above):
```bash
export PATH=${PATH}:~/.composer/vendor/bin
```


## Usage
```bash
bentodb <command> [options]

bentodb configure         - Set your BentoDB API key
bentodb whoami            - Get your BentoDB user information
bentodb create            - Create a new database
bentodb ls                - List your databases
bentodb delete id=xyz     - Delete a database
```