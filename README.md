# zm-montage
 An extended, better montage for monitoring.

## Setup

Place these PHP Files into an HTTP server with PHP enabled.

Edit `zmconfig.php` and put in all the needed Information.

## How to use

Call the file `zmmontage.php` from your client.

Parameters can either be provided by appending them in `HTTP GET` form, 
or by including them in an `HTTP POST` request.  
When both are provided, `HTTP GET` is preferred. 

Parameter | Description | Default
--------- | ----------- | -------
`ids` | An `-` seperated list of cameras to be shown | none
`refresh` | Time in seconds the whole webpage should be refreshed | 120
`imgtimeout` | Timeout for one stream at which point its treated unavailable | 2.5
`quality` | Quality of the stream in percent, high quality is bandwidth and server intensive | 50
`fps` | Frames per second for the streams | 5
`noerror` | Remove stream instead of replacing it with `alturl` | 1


`alturl`: This Parameter is configured within the `zmmontage.php` file. 
It describes which web url should be shown when no stream is available.
This defaults to the provided `unavailable.png` image.

If you only want to display one stream, set `ids` only to the number of the stream.

## Security

When using an Apache 2 Webserver, 
the provided `.htaccess` file should protect your credentials. 

When not, 
think of another way to hide the file `zmconfig.php` from the public.

Either way, 
please make sure the file is not accesible over HTTP.
