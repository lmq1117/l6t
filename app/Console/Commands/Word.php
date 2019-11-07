<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\TemplateProcessor;

use PhpOffice\PhpWord\Element\Field;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use \PhpOffice\PhpWord\Settings;

class Word extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'word';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->word();
    }


    private function word(){
        Settings::setTempDir("./");
        $this->info(date('H:i:s') . ' Creating new TemplateProcessor instance...');

        $templateProcessor = new TemplateProcessor("template/Sample_40_TemplateSetComplexValue.docx");

        $title = new TextRun();
        $title->addText('This title has been set ', array('bold' => true, 'italic' => true, 'color' => 'blue'));
        $title->addText('dynamically', array('bold' => true, 'italic' => true, 'color' => 'red', 'underline' => 'single'));
        $templateProcessor->setComplexBlock('title', $title);


        $inline = new TextRun();
        $inline->addText('by a red italic text', array('italic' => true, 'color' => 'red'));
        $templateProcessor->setComplexValue('inline', $inline);

        $table = new Table(array('borderSize' => 12, 'borderColor' => 'green', 'width' => 6000, 'unit' => TblWidth::TWIP));
        $table->addRow();
        $table->addCell(150)->addText('Cell A1');
        $table->addCell(150)->addText('Cell A2');
        $table->addCell(150)->addText('Cell A3');
        $table->addRow();
        $table->addCell(150)->addText('Cell B1');
        $table->addCell(150)->addText('Cell B2');
        $table->addCell(150)->addText('Cell B3');
        $templateProcessor->setComplexBlock('table', $table);

        $field = new Field('DATE', array('dateformat' => 'dddd d MMMM yyyy H:mm:ss'), array('PreserveFormat'));
        $templateProcessor->setComplexValue('field', $field);

        $this->info(date('H:i:s') . ' Saving the result document...');
        $templateProcessor->saveAs('results/Sample_40_TemplateSetComplexValue.docx');

        $this->info(date('H:i:s') . ' results/Sample_40_TemplateSetComplexValue.docx');
        //echo getEndingNotes(
        //    array('Word2007' => 'docx'), 'results/Sample_40_TemplateSetComplexValue.docx'
        //);



    }


    private function word1(){
        //return;
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

// Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );

// Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
            $fontStyleName
        );

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');
        $this->info('helloWorld.docx');

    }
}
