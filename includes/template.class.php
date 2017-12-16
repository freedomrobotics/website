<?php
class Template {
  private $templateDir = "templates/";
  private $leftDelimiter = '{$';
  private $rightDelimiter = '}';

  private $leftDelimiterIf = '{#';
  private $rightDelimiterIf = '}';

  private $leftDelimiterIfEnd = '{#end.';
  private $rightDelimiterIfEnd = '}';

  private $leftDelimiterComment = '{/*}';
  private $rightDelimiterComment = '{*/}';

  private $templateName = "";
  private $templateFile = "";

  private $template = "";

  public function __construct($tpl_dir = "") {
      if (!empty($tpl_dir) ) {
          $this->templateDir = $tpl_dir;
      }
  }

  public function load($file) {
    $this->templateName = $file;
    $this->templateFile = $this->templateDir.$file;
    if( !empty($this->templateFile) ) {
        if( file_exists($this->templateFile) ) {
            $this->template = file_get_contents($this->templateFile);
        } else {
            return false;
        }
    } else {
       return false;
    }
  }

  public function assign($replace, $replacement) {
      $this->template = str_replace( $this->leftDelimiter .$replace.$this->rightDelimiter,
                                     $replacement, $this->template );
  }

  public function assignIf($name, $toShow) {
    if ($toShow) {
      $this->template = str_replace($this->leftDelimiterIf.$name.$this->rightDelimiterIf, "", $this->template);
      $this->template = str_replace($this->leftDelimiterIfEnd.$name.$this->rightDelimiterIfEnd, "", $this->template);
    } else {

      $beginningPos = strpos($this->template, $this->leftDelimiterIf.$name.$this->rightDelimiterIf);
      $endPos = strpos($this->template, $this->leftDelimiterIfEnd.$name.$this->rightDelimiterIfEnd);

      while ($beginningPos && $endPos) {
          $textToDelete = substr($this->template, $beginningPos, ($endPos + strlen($this->leftDelimiterIfEnd.$name.$this->rightDelimiterIfEnd)) - $beginningPos);
          $this->template = str_replace($textToDelete, '', $this->template);

          $beginningPos = strpos($this->template, $this->leftDelimiterIf.$name.$this->rightDelimiterIf);
          $endPos = strpos($this->template, $this->leftDelimiterIfEnd.$name.$this->rightDelimiterIfEnd);
      }
    }
  }

  private function removeComments() {
    $beginningPos = strpos($this->template, $this->leftDelimiterComment);
    $endPos = strpos($this->template, $this->rightDelimiterComment);

    while ($beginningPos && $endPos) {
        $textToDelete = substr($this->template, $beginningPos, ($endPos + strlen($this->rightDelimiterComment)) - $beginningPos);
        $this->template = str_replace($textToDelete, '', $this->template);

        $beginningPos = strpos($this->template, $this->leftDelimiterComment);
        $endPos = strpos($this->template, $this->rightDelimiterComment);
    }
  }

  public function display() {
    $this->removeComments();
    echo $this->template;
  }


}
?>
