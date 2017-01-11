# HideMe Linux Pinger

## Main Info

Now with more folders and files! Because composer and community say, that i must do my shit this way.
Generally speaking, I also have to connect the DI. Oh, I forgot Facades (or Proxy Object). 

How could I forget about contracts (interfaces)? I shall describe the interface to my poor, nothing derived class.
Indeed, no one will understand my fucking, 80 lines long, code, if don't write interface.


## Interact with the script

```bash
php php_pinger.php -s -f <value> -p <value> --silence --file=<value> --ping-count=<value>
```

* `-s` - force script output only final result;
* `-f <value>` - specify path to OpenVPN config file;
* `-p <value>` - how many times script will ping remote host (bigger value - more accurate result);
* `--silence` - see `s`;
* `--file=<value>` - see `-f <value>`;
* `--ping-count=<value>` - see `-p <value>`;
