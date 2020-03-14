# zm-montage
 An extended, better montage for monitoring.

## Setup

Place these PHP Files into an HTTP server with PHP enabled.

Edit `zmconfig.php` and put in all the needed Information.

## How to use

Call the file `wall.php` or `single.php` from your client.

You can append your parameters in HTTP GET from.

Parameter | Description | Default
--------- | ----------- | -------
`ids` | An `-` seperated list of cameras to be shown | none
`refresh` | Time in seconds the whole webpage should be refreshed | 120
`imgtimeout` | Timeout for one stream at which point its treated unavailable | 2.5
`quality` | Quality of the stream in percent, high quality is bandwidth and server intensive | 50
`fps` | Frames per second for the streams | 5
`noerror` | Remove stream instead of replacing it with `alturl` | 1


`alturl`: This Parameter is configured within the `wall.php` file. 
It describes which web url should be shown when no stream is available.
This defaults to the provided `unavailable.png` image.

Difference between `wall.php` and `single.php`: 
In `single.php` the parameter `ids` is called `id`, 
because (as the name says) it only displays one stream.

`single.php` might soon be removed, as you can also call `wall.php` with only one id provided.

## Security

When using an Apache 2 Webserver, 
the provided `.htaccess` file should protect your credentials. 

When not, 
think of another way to hide the file `zmconfig.php` from the public.

Either way, 
please make sure the file is not accesible over HTTP.
