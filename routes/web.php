<?php

Route::view('/{vue_capture?}', 'home')->where('vue_capture', '[\/\w\.-]*');
