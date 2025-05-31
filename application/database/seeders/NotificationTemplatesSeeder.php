<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Descomenta si quieres partir de cero cada vez
        // DB::table('notification_templates')->truncate();

        $templates = [

            /* ───────── Default Template ───────── */
            [
                'name'         => 'Default Template',
                'act'          => 'DEFAULT',
                'status'       => 1,
                'subj'         => '{{subject}}',
                'email_body'   => '{{message}}',
                'email_status' => 1,
                'sms_body'     => '{{message}}',
                'sms_status'   => 1,
                'shortcodes'   => json_encode([
                    'subject' => 'Asunto',
                    'message' => 'Mensaje',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Booking (cliente) ───────── */
            [
                'name'         => 'Booking Confirmed!',
                'act'          => 'BOOKING_CONFIRMED',
                'status'       => 1,
                'subj'         => '¡Reserva confirmada!',
                'email_body'   => "¡Este correo electrónico confirma tu reserva en {{product}}!! Nos alegra mucho verte.\n\n"
                                . "Detalles de la reserva:\n"
                                . "- Gimnasio: {{product}}\n"
                                . "- Ubicación: {{location}}\n"
                                . "- Fecha: {{booking_date}}\n"
                                . "- Hora: {{booking_time}}\n\n"
                                . "Información:\n"
                                . "- Por favor, llega 30 minutos antes de tu hora programada para poder registrarte.\n"
                                . "- Recuerda traer tu tarjeta de socio del gimnasio o la información de registro digital.\n\n"
                                . "¡Esperamos ayudarte a alcanzar tus objetivos de fitness!\n"
                                . "Atentamente,\n\n"
                                . "{{site_name}}",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'location'     => 'Ubicación',
                    'product'      => 'Product Title',
                    'booking_date' => 'Booking Date',
                    'booking_time' => 'Booking Time',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Booking Gym Confirmed (propietario) ───────── */
            [
                'name'         => 'Booking Gym Confirmed!',
                'act'          => 'BOOKING_GYM_CONFIRMED',
                'status'       => 1,
                'subj'         => '¡Reserva confirmada!',
                'email_body'   => "{{user}} acaba de solicitar una reserva en su gimnasio.\n\n"
                                . "Detalles de la reserva:\n"
                                . "- Usuario: {{user}}\n"
                                . "- Fecha: {{booking_date}}\n"
                                . "- Hora: {{booking_time}}\n\n"
                                . "Atentamente,\n\n"
                                . "{{site_name}}",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'user'         => 'Usuario',
                    'booking_date' => 'Booking Date',
                    'booking_time' => 'Booking Time',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Gym Added Successfully ───────── */
            [
                'name'         => 'Gym Added Successfully!',
                'act'          => 'GYM_ADDED',
                'status'       => 1,
                'subj'         => '¡Gimnasio añadido exitosamente!',
                'email_body'   => "Tu gimnasio ({{product}}) se ha creado correctamente.\n"
                                . "Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos a través de este correo electrónico.\n"
                                . "¡Esperamos verte en el gimnasio!\n"
                                . "Atentamente,\n\n"
                                . "{{site_name}}.",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'product' => 'Product Title',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Password Reset – Code ───────── */
            [
                'name'         => 'Password - Reset - Code',
                'act'          => 'PASSWORD_RESET_CODE',
                'status'       => 1,
                'subj'         => 'Restablecer contraseña',
                'email_body'   => "Hemos recibido una solicitud para restablecer la contraseña de su cuenta el {{time}}.\n\n"
                                . "Solicitada desde la IP: {{ip}} usando el {{browser}} en el {{operating_system}}.\n\n"
                                . "Su código de recuperación de cuenta es:  {{code}}\n"
                                . "Si no desea restablecer su contraseña, ignore este mensaje.",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'code'            => 'Verification code for password reset',
                    'ip'              => 'IP address of the user',
                    'browser'         => 'Browser of the user',
                    'operating_system'=> 'Operating system of the user',
                    'time'            => 'Time of the request',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Password Reset – Confirmation ───────── */
            [
                'name'         => 'Password - Reset - Confirmation',
                'act'          => 'PASSWORD_RESET_CONFIRMATION',
                'status'       => 1,
                'subj'         => 'Has restablecido tu contraseña',
                'email_body'   => "Has restablecido tu contraseña correctamente.\n"
                                . "Cambiaste tu\n"
                                . "IP: {{ip}} usando {{browser}} en {{operating_system}} el {{time}}.\n\n"
                                . "Si no la has cambiado, contáctanos lo antes posible.",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'ip'              => 'IP address of the user',
                    'browser'         => 'Browser of the user',
                    'operating_system'=> 'Operating system of the user',
                    'time'            => 'Time of the request',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /* ───────── Verification Email ───────── */
            [
                'name'         => 'Verification - Email',
                'act'          => 'VERIFICATION_EMAIL',
                'status'       => 1,
                'subj'         => 'Por favor verifique su dirección de correo electrónico',
                'email_body'   => "Gracias por unirte a nosotros.\n\n"
                                . "Usa el siguiente código para verificar tu correo electrónico.\n\n"
                                . "Tu código de verificación es: {{code}}",
                'email_status' => 1,
                'sms_body'     => '---',
                'sms_status'   => 0,
                'shortcodes'   => json_encode([
                    'code' => 'Email verification code',
                ], JSON_UNESCAPED_UNICODE),
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        DB::table('notification_templates')->insert($templates);
    }
}
