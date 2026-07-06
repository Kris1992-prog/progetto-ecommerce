# 1. Usiamo l'immagine ufficiale con Apache e PHP pre-installati
FROM php:8.2-apache

# 2. Installiamo le estensioni necessarie
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 3. QUESTA È LA RIGA CHE MANCAVA!
# Copia tutto il contenuto della cartella corrente (il tuo progetto) 
# dentro la cartella del web server Apache
COPY . /var/www/html/

# 4. (Opzionale) Assicuriamoci che i permessi siano corretti
RUN chown -R www-data:www-data /var/www/html