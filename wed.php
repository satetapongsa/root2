sudo chown -R www-data:www-data /var/www/html/iot_dashboard
sudo chmod -R 755 /var/www/html/iot_dashboard

sudo systemctl status apache2
sudo systemctl start apache2

