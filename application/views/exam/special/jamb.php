<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo '<section class="container">';
echo '<section class="bg-secondary text-center pt-3 pb-3">';
echo '<h3 class="h3 text-white">Select Practice Environment</h3>';
echo '</section>';
echo '<section class="p-5">';
echo '<div class="container">';
echo '<div class="p-2">';
echo '<button type="button" class="btn btn-primary btn-lg p-3">';
echo anchor('exam/content/question/subject/4/JAMB?simulator=simulator', 'Jamb Simulator', 'class="text-white"');
echo '</button>';
echo '</div>';
echo '<div class="p-2">';
echo '<button type="button" class="btn btn-success btn-lg p-3">';
echo anchor('exam/content/question/subject/4/JAMB?subjects=subjects', 'Practice by Subjects', 'class="text-white"');
echo '</button>';
echo '</div>';
echo '</div>';
echo '</section>';
echo anchor('exam/content/home', 'Choose Another Examination', 'class="btn btn-dark"');
echo '</section>';