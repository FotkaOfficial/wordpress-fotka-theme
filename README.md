# Motyw WordPress Fotka

Nowoczesny motyw blogowy oparty na projekcie Fotka z pełnym panelem administracyjnym.

## 📋 Funkcje

### ✅ Zaimplementowane funkcje:

1. **Logo** - Natywne wsparcie WordPressa (Wygląd → Dostosuj → Tożsamość witryny)

2. **Social Media w Nagłówku** - Pełne zarządzanie:
   - Dodawanie/usuwanie linków
   - Dropdown z wyborem platformy (Facebook, Twitter, Instagram, LinkedIn, YouTube, TikTok, Pinterest, WhatsApp)
   - Ikony Font Awesome

3. **Udostępnianie Artykułów** - Zarządzane z panelu:
   - Wybór platform do udostępniania
   - Przyciski pod artykułami
   - Automatyczne generowanie linków share

4. **Prawy Sidebar** - W pełni zarządzalny:
   - Widget "Fotka: Lista Kategorii" z licznikami
   - Widget "Fotka: Popularne Posty" z miniaturkami
   - Natywne widgety WordPress (wyszukiwarka, menu, tekst, itp.)

5. **Stopka**:
   - 3 obszary widgetowe
   - Edytowalny tekst stopki (może zawierać HTML)
   - Linki do aplikacji mobilnych (Android/iOS)

6. **Meta Tagi i Skrypty Śledzące**:
   - Pole textarea dla skryptów w `<head>` (Google Analytics, Tag Manager, tagi weryfikacyjne)
   - Pole textarea dla skryptów przed `</body>`
   - Bezpieczna sanityzacja z zachowaniem tagów `<script>`, `<meta>`, `<link>`

## 🚀 Instalacja

1. Wypakuj folder `fotka-theme` do katalogu `/wp-content/themes/`
2. W panelu WordPress przejdź do: **Wygląd → Motywy**
3. Aktywuj motyw **Fotka**

## ⚙️ Konfiguracja

### Panel Administracyjny

Wszystkie ustawienia znajdziesz w: **Wygląd → Dostosuj → Ustawienia Motywu Fotka**

#### 1. Logo
- **Wygląd → Dostosuj → Tożsamość witryny → Logo**
- Prześlij swoje logo (zalecane: wysokość 60-100px)

#### 2. Social Media - Nagłówek
- Kliknij **"+ Dodaj kolejny link"**
- Wybierz platformę z dropdownu
- Wklej URL do profilu
- Możesz dodać dowolną liczbę linków
- Aby usunąć, kliknij ikonę kosza

#### 3. Udostępnianie Artykułów
- Zaznacz platformy, na których chcesz umożliwić udostępnianie
- Dostępne: Facebook, Twitter, LinkedIn, Pinterest, WhatsApp
- Przyciski pojawią się automatycznie pod każdym artykułem

#### 4. Stopka
- **Tekst stopki**: Wpisz tekst copyright (możesz używać HTML)
- **Link do aplikacji Android**: URL w Google Play
- **Link do aplikacji iOS**: URL w App Store

#### 5. Kody Śledzące i Meta Tagi
- **Skrypty w sekcji `<head>`**: 
  - Google Analytics
  - Google Tag Manager
  - Meta Pixel (Facebook)
  - Tagi weryfikacyjne (Google Search Console, Bing, itp.)
  
- **Skrypty przed `</body>`**:
  - Skrypty, które powinny być załadowane na końcu strony

**Przykład - Google Analytics:**
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

**Przykład - Meta tagi weryfikacyjne:**
```html
<meta name="google-site-verification" content="twój-kod-weryfikacyjny" />
```

### Widgety - Sidebar

**Wygląd → Widgety → Sidebar**

Dostępne widgety:
- **Fotka: Lista Kategorii** - Kategorie z licznikami
- **Fotka: Popularne Posty** - Najczęściej czytane artykuły z miniaturkami
- **Wyszukiwarka** - Natywny widget WordPress
- **Menu niestandardowe** - Możesz dodać menu stworzone w **Wygląd → Menu**
- Wszystkie inne natywne widgety WordPress

### Widgety - Stopka

**Wygląd → Widgety → Footer Widget Area 1/2/3**

Stopka podzielona jest na 3 kolumny. Możesz w każdej umieścić:
- Menu
- Tekst z linkami
- Social media
- Dowolne widgety

## 📱 Responsywność

Motyw jest w pełni responsywny:
- Desktop (>968px): Sidebar po prawej
- Tablet (768-968px): Sidebar pod treścią
- Mobile (<768px): Pojedyncza kolumna

## 🎨 Dostosowywanie Wyglądu

### Kolory
Główny kolor motywu to `#00a8e1` (niebieski). 

Aby zmienić, edytuj w pliku `assets/css/main.css`:
```css
/* Znajdź i zamień #00a8e1 na swój kolor */
```

### Czcionki
Motyw używa system fonts. Aby zmienić, edytuj `body` w `assets/css/main.css`

## 📝 Wymagania

- WordPress 5.0+
- PHP 7.4+
- Zalecane: posty z obrazami wyróżniającymi

## 🔧 Struktura Plików

```
fotka-theme/
├── style.css                     # Metadane motywu
├── functions.php                 # Funkcje główne
├── index.php                     # Lista postów
├── single.php                    # Pojedynczy post
├── header.php                    # Nagłówek
├── footer.php                    # Stopka
├── sidebar.php                   # Sidebar
├── inc/
│   ├── customizer.php           # Panel administracyjny
│   ├── social-media.php         # Obsługa social media
│   ├── template-functions.php   # Funkcje pomocnicze
│   └── widgets/
│       ├── class-categories-widget.php
│       └── class-popular-posts-widget.php
├── template-parts/
│   └── content-card.php         # Karta wpisu
└── assets/
    ├── css/
    │   ├── main.css             # Style główne
    │   └── customizer-controls.css
    └── js/
        ├── main.js              # JavaScript główny
        └── customizer-controls.js
```

## 💡 Wskazówki

1. **Social Media Icons**: Motyw używa Font Awesome 6.4.0 - ikony ładują się automatycznie

2. **Popularne Posty**: Widget bazuje na liczbie komentarzy. Im więcej komentarzy, tym wyżej w rankingu

3. **Powiązane Posty**: Pod artykułem automatycznie pokazują się 3 powiązane posty z tej samej kategorii

4. **Menu**: Stwórz menu w **Wygląd → Menu** i przypisz je do lokalizacji "Primary Menu" lub "Footer Menu"

5. **Obrazy**: 
   - Obrazy wyróżniające (zalecane: 800x600px)
   - Miniaturki automatycznie generowane

6. **Aktualizacje z GitHub**: Możesz skonfigurować automatyczne aktualizacje z GitHuba - zobacz plik `GITHUB-UPDATES.md`

## 🐛 Rozwiązywanie Problemów

**Problem**: Nie widzę widgetów w sidebarze
- Rozwiązanie: Przejdź do **Wygląd → Widgety** i dodaj widgety do obszaru "Sidebar"

**Problem**: Nie działają ikony social media
- Rozwiązanie: Sprawdź czy Font Awesome się załadował (możliwa blokada przez wtyczkę lub firewall)

**Problem**: Skrypty śledzące nie działają
- Rozwiązanie: Sprawdź w kodzie źródłowym strony czy skrypty się dodały. Jeśli nie, sprawdź czy nie ma błędów składniowych w kodzie

## 📄 Licencja

GPL v2 or later

## 👨‍💻 Wsparcie

W razie problemów:
1. Sprawdź konsolę przeglądarki (F12) czy nie ma błędów JavaScript
2. Włącz tryb debugowania WordPress (`WP_DEBUG`)
3. Sprawdź logi błędów

---

**Autor**: Grzegorz Broża  
**Wersja**: 1.5.2  
**Wymaga**: WordPress 5.0+
