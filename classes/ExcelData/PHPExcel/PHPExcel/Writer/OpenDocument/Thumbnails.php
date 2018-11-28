<?php

/**
 * PHPExcel_Writer_OpenDocument_Thumbnails
 *
 * Copyright (c) 2006 - 2015 ExcelData
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   ExcelData
 * @package    PHPExcel_Writer_OpenDocument
 * @copyright  Copyright (c) 2006 - 2015 ExcelData (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PHPExcel_Writer_OpenDocument_Thumbnails extends PHPExcel_Writer_OpenDocument_WriterPart
{
    /**
     * Write Thumbnails/thumbnail.png to PNG format
     *
     * @param   PHPExcel                   $pPHPExcel
     * @return  string                     XML Output
     * @throws  PHPExcel_Writer_Exception
     */
    public function writeThumbnail(PHPExcel $pPHPExcel = null)
    {
        return '';
    }
}