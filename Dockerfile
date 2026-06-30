# --- FASE 1: La "Cucina" (Builder) ---
# Usiamo l'immagine base per installare e compilare tutto
FROM php:8.2-apache AS builder

# Installiamo le estensioni (qui si crea il "disordine" di file temporanei)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# --- FASE 2: La "Produzione" (Final) ---
# Partiamo da una immagine base pulita e fresca
FROM php:8.2-apache

# Copiamo SOLO le estensioni compilate dalla FASE 1 alla FASE 2
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/

# Copiamo anche i file di configurazione (.ini) che attivano le estensioni
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/