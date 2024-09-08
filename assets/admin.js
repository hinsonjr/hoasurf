/* 
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */
import './styles/admin.css';

$('#form_createOwner').on('click', function ()
{
    if ($('#form_createOwner').is(":checked"))
    {
        $('#createOwnerContainer').show();
    } else
    {
        $('#createOwnerContainer').hide();
    }
});

