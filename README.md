# Horizon Theme Functions

This repository contains a set of helper functions that can be used in any WordPress theme. These functions provide features such as SVG icon rendering, browser detection, menu customizations, color conversions, text manipulations, and reading time estimation for posts.

## Table of Contents

- [Installation](#installation)
- [Functions](#functions)
  - [horizon_the_icon](#horizon_the_icon)
  - [horizon_get_browser](#horizon_get_browser)
  - [horizon_add_admin_link](#horizon_add_admin_link)
  - [horizon_hex_to_rgba](#horizon_hex_to_rgba)
  - [horizon_line_to_break](#horizon_line_to_break)
  - [horizon_line_to_span](#horizon_line_to_span)
  - [horizon_line_to_span_and_break](#horizon_line_to_span_and_break)
  - [horizon_reading_time](#horizon_reading_time)
- [License](#license)

## Installation

These functions are theme-agnostic, meaning they can be used in any WordPress theme. To integrate these functions into your theme, follow these steps:

1. **Copy the code**: Copy the functions from this repository into your theme's `functions.php` file. You can paste them at the end of the file or at the appropriate section where custom functions are included.

2. **Ensure proper setup**: Make sure your theme loads functions from the `functions.php` file, which is standard for WordPress themes.

3. **Icons Directory**: If you want to use the `horizon_the_icon` function, create a directory called `/icons/` within your theme’s root directory and add your SVG icons there.

Once integrated, you can use these functions across your theme's templates.
