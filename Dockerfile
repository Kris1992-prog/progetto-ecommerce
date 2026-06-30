# --- FASE 1: La "Cucina" (Build) ---
FROM php:8.2-apache AS builder
# Qui installiamo strumenti, scarichiamo librerie, compiliamo il codice
# (Tutto il "disordine" resta confinato qui dentro)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# --- FASE 2: Il "Piatto Pronto" (Production) ---
FROM php:8.2-apache
# Qui copiamo SOLO il risultato finale dalla FASE 1
COPY --from=builder /usr/local/lib/php/extensions/no-debug-non-zts-20220829/ /usr/local/lib/php/extensions/no-debug-non-zts-20220829/
# (Qui l'immagine è pulita, leggera e pronta per il cliente)