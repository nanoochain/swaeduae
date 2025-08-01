#!/bin/bash
usage="\$(free -m | awk '/Mem/ {print \$3/\$2 * 100.0}')"
disk=\$(df / | awk 'END{print \$5}' | tr -d '%')
if (( \${usage%%.*} > 90 || \$disk > 90 )); then
  echo "Warning: Resource usage high! Mem: \$usage, Disk: \$disk%" | mail -s "SawaedUAE Server Alert" admin@swaeduae.ae
fi
