# Gebruik een basis Nginx image
FROM nginx:alpine

# Kopieer je HTML- en CSS-bestanden naar de standaard Nginx map
COPY . /usr/share/nginx/html

# Expose poort 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
